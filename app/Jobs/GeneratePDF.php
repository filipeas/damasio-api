<?php

namespace App\Jobs;

use App\Category;
use Illuminate\Filesystem\Filesystem;
use Barryvdh\DomPDF\Facade as PDF;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $pdf_fixo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pdf_fixo)
    {
        $this->pdf_fixo = $pdf_fixo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * Método responsável por gerar PDF's das categorias a partir do banco de dados.
         * Esse método exclui todos os PDF's já gerados e os recria.
         * Também exclui os PDF's de sumários temporários no final do processo.
         */

        // retornando categorias na ordem algabetica
        $categories = Category::whereNull('parent')->orderBy('title', 'ASC')->get();

        // antes de enviar ao job, deve ser verificado se há categorias para ser processado
        if ($categories->isEmpty()) {
            return response()->json('Não há categorias para processar', 200);
        }

        // removendo apontamento dos PDF's de cada categoria
        foreach ($categories as $category) {
            $category->pdf = null;
            $category->save();
        }

        // removendo todos os PDF's do diretório
        $file = new Filesystem;
        $file->cleanDirectory(public_path('storage/pdfs'));

        // caminhos fixos
        $path = public_path('storage/pdfs'); // diretorio que guardará o pdf da categoria
        $path_tmp = public_path('storage/tmp'); // diretorio que guardará o pdf do sumario (temporario)

        // nº de páginas do PDF fixo
        $numPagesPDFFix = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $this->pdf_fixo))), $dummy) + 2;

        foreach ($categories as $category) {
            gc_disable();

            // nome do arquivo pdf que será gerado
            $fileName =  $category->title . '.' . 'pdf';

            // criando sumário da categoria para depois anexar
            $arr_pages = [];
            $pagina = $numPagesPDFFix;
            foreach ($category->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
                if ($pagina == ($pagina - 1)) {
                    array_push($arr_pages, [$subcategory->title => $pagina]);
                    $pagina += (int)($subcategory->products()->count() / ($pagina - 2)) + 1;
                    continue;
                }
                array_push($arr_pages, [$subcategory->title => $pagina]);
                $pagina += (int)($subcategory->products()->count() / 9) + 1;
            }

            // gerando pdf do sumario da categoria
            $sumario = PDF::loadView('sumario', ['category' => $category, 'pages' => $arr_pages]);
            $sumario->save($path_tmp . '/' . $fileName); // salvando pdf do sumario gerado

            // nº de páginas do sumário
            $numPagesSumary = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($path_tmp . '/' . $fileName)), $dummy);

            // gerando pdf da categoria com paginação
            $pdf = PDF::loadView('index', ['categories' => $category, 'page' => (($numPagesPDFFix - 2) + $numPagesSumary)]);

            $pdf->save($path . '/' . $fileName); // salvando pdf do catalogo

            // colocando paginas fixas no inicio no PDF gerado
            $pdfMerger = PDFMerger::init();
            $pdfMerger->addPDF(public_path('storage' . $this->pdf_fixo), 'all'); // anexa as paginas fixas
            $pdfMerger->addPDF($path_tmp . '/' . $fileName, 'all'); // anexa o sumario da categoria
            $pdfMerger->addPDF($path . '/' . $fileName, 'all'); // anexa as paginas da categoria
            $pdfMerger->merge();
            $pdfMerger->save(public_path('storage/pdfs/' .  $fileName), "file");

            gc_enable();
            gc_collect_cycles();

            // salvar caminho do PDF na categoria do banco de dados
            $category->pdf = "pdfs/{$fileName}";
            $category->save();

            // limpando diretório dos sumários
            $file->cleanDirectory(public_path('storage/tmp'));
        }
    }
}
