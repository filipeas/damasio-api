<?php

namespace App\Jobs;

use App\Category;
use App\Product;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * Método responsável por gerar PDF's a partir do banco de dados.
         * Esse método exclui todos os PDF's já gerados e os recria.
         */

        // retornando categorias na ordem algabetica
        $categories = Category::whereNull('parent')->orderBy('title', 'ASC')->get();

        // antes de enviar ao job, deve ser verificado se há categorias para ser processado
        if ($categories->isEmpty()) {
            return response()->json('Não há categorias para processar', 404);
        }

        // removendo apontamento dos PDF's de cada categoria
        foreach ($categories as $category) {
            $category->pdf = null;
            $category->save();
        }

        // removendo todos os PDF's do diretório
        $file = new Filesystem;
        $file->cleanDirectory(public_path('storage/pdfs'));

        // array de PDF's gerados. E usado para fazer merge de todos os PDF's gerados no final
        $pdfs = [];
        // controle do número da página corrente
        $pagina = 0;

        foreach ($categories as $category) {
            gc_disable();

            $pdf = PDF::loadView('index', ['categories' => $category, 'page' => $pagina]);

            $path = public_path('storage/pdfs');
            $path_fixed_pages = public_path('storage/fixed pages');
            $fileName =  $category->title . '.' . 'pdf';

            $pdf->save($path . '/' . $fileName);
            // array_push($pdfs, $path . '/' . $fileName);

            // colocando paginas fixas no inicio no PDF gerado
            $pdfMerger = PDFMerger::init();

            $pdfMerger->addPDF($path_fixed_pages . '/paginas-fixas.pdf', 'all');
            $pdfMerger->addPDF($path . '/' . $fileName, 'all');

            $pdfMerger->merge();
            $pdfMerger->save(public_path('storage/pdfs/' .  $fileName), "file");

            // ajustando contagem de páginas para inserir a pagina atual correta no proximo loop
            $countProducts = Product::where('subcategory', $category->id)->count();
            for ($i = $countProducts; $i > 0; $i = $i - 9) {
                $pagina += 1;
            }

            gc_enable();
            gc_collect_cycles();

            // salvar caminho do PDF na categoria
            $category->pdf = "pdfs/{$fileName}";
            $category->save();
        }

        // $pdfMerger = PDFMerger::init();

        // foreach ($pdfs as $newpdf) {
        //     $pdfMerger->addPDF($newpdf, 'all');
        // }

        // $pdfMerger->merge();
        // $pdfMerger->save(public_path('storage/pdfs/catalogo_completo.pdf'), "file");
    }
}
