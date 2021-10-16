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

class GenerateFinalPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
         * Esse método cria os pdfs das categorias e armazena em um array e, no final,
         * junta todos em um unico arquivo.
         */

        // retornando categorias na ordem algabetica
        $categories = Category::whereNull('parent')->orderBy('title', 'ASC')->get();

        // antes de enviar ao job, deve ser verificado se há categorias para ser processado
        if ($categories->isEmpty()) {
            return response()->json('Não há categorias para processar', 200);
        }

        // pdfs gerados. é usado para fazer merge de todos os pdfs gerados no final
        $pdfs = [];

        // caminhos fixos
        $path = public_path('storage/tmp'); // diretorio que guardará o pdf da categoria

        // nº de páginas do PDF fixo
        $pagina = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $this->user->pdf_fixo))), $dummy);

        // gerando pdf do sumário (gerar a primeira vez para calcular a quantidade de paginas)
        $arr_categories = [];
        foreach ($categories as $category) {
            $arr_pages = [];
            foreach ($category->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
                array_push($arr_pages, [$subcategory->title => $pagina]);
            }
            array_push($arr_categories, [
                'subcategories' => $arr_pages,
                'category' => $category->title,
                'color' => $category->color,
                'title_color' => $category->title_color,
            ]);
        }

        // gerando pdf do sumario da categoria
        $sumario = PDF::loadView('sumario_final', [
            'categories' => $arr_categories,
            'page' => $pagina
        ]);
        // return $sumario->stream('sumario_final.pdf');
        $sumario->save($path . '/sumario.pdf'); // salvando pdf do sumario gerado

        // atualizando posição da página corrente
        $paginasDoSumario = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($path . '/sumario.pdf')), $dummy) - 1;
        $pagina = $paginasDoSumario + preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $this->user->pdf_fixo))), $dummy);

        // criando array de categorias para inserir na coluna lateral de cada página gerada
        $arr_columns_categories = array_chunk($arr_categories, 8);
        // marcando arrays como não visitados
        foreach ($arr_columns_categories as $key1 => $multiple_categories) {
            foreach ($multiple_categories as $key2 => $actual_category) {
                $arr_columns_categories[$key1][$key2]['marked'] = false;
            }
        }

        // reseta array de categorias para montar o sumário final
        $arr_categories = [];

        // gerando pdfs das categorias
        foreach ($categories as $key => $category) {
            // teste para as 4 primeiras categorias
            // if ($key > 4) {
            //     continue;
            // }

            gc_disable();

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
                array_push($pdfs, public_path('storage' . $category->propaganda)); // guardar pdf da propaganda da subcategoria no array final
                $pagina += preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $category->propaganda))), $dummy) + 1;
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

                $fileName =  Str::slug($subcategory->title) . '_subcategoria_' . time() . '.' . 'pdf';

                $pdf->save($path . '/' . $fileName);
                array_push($pdfs, $path . '/' . $fileName); // guardar pdf da subcategoria no array final

                // ajustando contagem de páginas para inserir a pagina atual correta no proximo loop
                $paginasDoPDFAtual = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($path . '/' . $fileName)), $dummy);
                $pagina += ($paginasDoPDFAtual == 1 ? $paginasDoPDFAtual : ($paginasDoPDFAtual - 1));

                gc_enable();
                gc_collect_cycles();
            }

            // array das categorias para o sumário
            array_push($arr_categories, [
                'subcategories' => $arr_pages,
                'category' => $category->title,
                'color' => $category->color,
                'title_color' => $category->title_color,
            ]);

            gc_enable();
            gc_collect_cycles();
        }

        // gerando pdf final do sumario
        $sumario = PDF::loadView('sumario_final', ['categories' => $arr_categories, 'page' => $pagina]);
        $sumario->save($path . '/sumario.pdf'); // salvando pdf do sumario gerado

        // anexação final (juntando todas as categorias em um único arquivo)
        // anexar todas as categorias em um unico arquivo
        $pdfMerger = PDFMerger::init();
        $pdfMerger->addPDF(public_path('storage' . $this->user->pdf_fixo), 'all'); // anexando as paginas fixas
        $pdfMerger->addPDF($path . '/sumario.pdf', 'all'); // anexando sumario criado
        foreach ($pdfs as $newpdf) {
            $numPages = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($newpdf)), $dummy) - 1;
            if ($numPages === 0)
                $numPages = 1;
            $pdfMerger->addPDF($newpdf, "1-{$numPages}"); // anexando pdfs das categorias
        }
        $pdfMerger->merge();
        $pdfMerger->save(public_path('storage/pdfs/catalogo_completo.pdf'), "file");

        // salvar caminho do PDF na categoria do banco de dados
        $this->user->pdf_completo = 'pdfs/catalogo_completo.pdf';
        $this->user->save();

        // limpando diretório temporario
        $file = new Filesystem;
        $file->cleanDirectory(public_path('storage/tmp'));
    }
}
