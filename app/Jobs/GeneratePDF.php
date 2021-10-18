<?php

namespace App\Jobs;

use App\Category;
use App\User;
use Illuminate\Filesystem\Filesystem;
use Barryvdh\DomPDF\Facade as PDF;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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

        // removendo apontamento do PDF final
        $user = User::first();
        $user->pdf_completo = null;
        $user->save();

        // caminhos fixos
        $path = public_path('storage/pdfs/'); // diretorio que guardará o pdf da categoria
        $path_tmp = public_path('storage/tmp/'); // diretorio que guardará o pdf do sumario (temporario)

        // removendo todos os PDF's do diretório
        $file = new Filesystem;
        $file->cleanDirectory($path);

        // nº de páginas do PDF fixo
        $paginaFixa = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $this->pdf_fixo))), $dummy);
        $paginaFixa += 2; // contando uma pagina do sumario (em teoria o sumario sempre vai ter so uma pagina)

        // gerando pdf do sumário (gerar a primeira vez para calcular a quantidade de paginas)
        $arr_categories = [];
        foreach ($categories as $category) {
            $arr_pages = [];
            foreach ($category->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
                array_push($arr_pages, [$subcategory->title => 0]);
            }
            array_push($arr_categories, [
                'subcategories' => $arr_pages,
                'category' => $category->title,
                'color' => $category->color,
                'title_color' => $category->title_color
            ]);
        }

        // criando array de categorias para inserir na coluna lateral de cada página gerada
        $arr_columns_categories = array_chunk($arr_categories, 8);
        // marcando arrays como não visitados
        foreach ($arr_columns_categories as $key1 => $multiple_categories) {
            foreach ($multiple_categories as $key2 => $actual_category) {
                $arr_columns_categories[$key1][$key2]['marked'] = false;
            }
        }

        // gerando pdfs das categorias
        foreach ($categories as $key => $category) {
            // teste para as 4 primeiras categorias
            // if ($key > 4) {
            //     continue;
            // }

            gc_disable();

            // pdfs gerados por categoria. é usado para anexar todos os pdfs da categoria e criar o pdf final da categoria
            $pdfs = [];

            // iniciando contagem de paginas
            $pagina = $paginaFixa;

            // reseta array de categorias para montar o sumário final
            $arr_categories = [];

            // reseta o array de paginas de subcategorias para montar o sumário final
            $arr_pages = [];

            // marcando arrays como não visitados
            $arr_categories_in_column = [];
            foreach ($arr_columns_categories as $key1 => $multiple_categories) {
                foreach ($multiple_categories as $key2 => $actual_category) {
                    if ($arr_columns_categories[$key1][$key2]['category'] == $category->title) {
                        $arr_columns_categories[$key1][$key2]['marked'] = true;
                        array_push($arr_categories_in_column, $arr_columns_categories[$key1]);
                    } else {
                        $arr_columns_categories[$key1][$key2]['marked'] = false;
                    }
                }
            }

            if ($category->propaganda != '') {
                array_push($pdfs, public_path('storage' . $category->propaganda)); // anexar pdf da propaganda da subcategoria no array final
                $pagina += preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $category->propaganda))), $dummy) - 1;
            }

            // percorrer subcategorias da categoria atual
            foreach ($category->subcategories()->orderBy('title', 'ASC')->get()
                as $key => $subcategory) {
                // atualizando numero de paginas do sumario
                array_push($arr_pages, [$subcategory->title => $pagina]);

                gc_disable();
                if ($category->model == 1) {
                    $pdf = PDF::loadView('layout_lista', [
                        'subcategory' => $subcategory,
                        'categories_column' => $arr_categories_in_column[0],
                        'page' => $pagina - 1,
                    ]);
                } elseif ($category->model == 0) {
                    $pdf = PDF::loadView('layout_bloco', [
                        'subcategory' => $subcategory,
                        'categories_column' => $arr_categories_in_column[0],
                        'page' => $pagina - 1,
                    ]);
                } else {
                    $pdf = PDF::loadView('layout_lista', [
                        'subcategory' => $subcategory,
                        'categories_column' => $arr_categories_in_column[0],
                        'page' => $pagina - 1,
                    ]);
                }

                $fileName =  $subcategory->title . '_subcategoria_' . time() . '.' . 'pdf';

                $pdf->save($path_tmp . '/' . $fileName);
                array_push($pdfs, $path_tmp . '/' . $fileName); // guardar pdf da subcategoria no array final

                // ajustando contagem de páginas para inserir a pagina atual correta no proximo loop
                $paginasDoPDFAtual = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($path_tmp . '/' . $fileName)), $dummy);
                $pagina += ($paginasDoPDFAtual == 1 ? $paginasDoPDFAtual : ($paginasDoPDFAtual - 1));

                gc_enable();
                gc_collect_cycles();
            }

            // array das categorias para o sumário
            array_push($arr_categories, [
                'subcategories' => $arr_pages,
                'category' => $category->title,
                'color' => $category->color,
                'title_color' => $category->title_color
            ]);

            // gerando pdf final do sumario da categoria atual
            $sumario = PDF::loadView('sumario_final', ['categories' => $arr_categories, 'page' => $pagina]);
            $sumario->save($path_tmp . 'sumario.pdf'); // salvando pdf do sumario gerado

            $filePath = Str::slug($category->title) . '_' . time();

            // anexação final (juntando todas as subcategorias em um único arquivo)
            $pdfMerger = PDFMerger::init();
            $pdfMerger->addPDF(public_path('storage' . $this->pdf_fixo), 'all'); // anexando as paginas fixas
            $pdfMerger->addPDF($path_tmp . 'sumario.pdf', 'all'); // anexando sumario criado
            foreach ($pdfs as $newpdf) {
                $numPages = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($newpdf)), $dummy) - 1;
                if ($numPages === 0)
                    $numPages = 1;
                $pdfMerger->addPDF($newpdf, "1-{$numPages}"); // anexando pdfs das categorias
            }
            $pdfMerger->merge();
            $pdfMerger->save($path . $filePath . '.pdf', "file");

            // salvar caminho do PDF na categoria do banco de dados
            $category->pdf = 'pdfs/' . $filePath . '.pdf';
            $category->save();

            // limpando diretório temporario
            $file->cleanDirectory($path_tmp);

            gc_enable();
            gc_collect_cycles();
        }
    }
}
