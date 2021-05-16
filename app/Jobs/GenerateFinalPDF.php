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

    // gerando cores aleatorias para os titulos das categorias no sumario
    function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 155)), 2, '0', STR_PAD_LEFT);
    }

    function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
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
        $pagina = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $this->user->pdf_fixo))), $dummy) + 2;

        // gerando pdf do sumário
        $arr_categories = [];
        foreach ($categories as $category) {
            $arr_pages = [];
            foreach ($category->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
                if ($pagina == ($pagina - 1)) {
                    array_push($arr_pages, [$subcategory->title => $pagina]);
                    $pagina += (int)($subcategory->products()->count() / ($pagina - 2)) + 1;
                    continue;
                }
                array_push($arr_pages, [$subcategory->title => $pagina]);
                $pagina += (int)($subcategory->products()->count() / 9) + 1;
            }
            array_push($arr_categories, ['subcategories' => $arr_pages, 'category' => $category->title, 'color' => $this->random_color()]);
        }

        // gerando pdf do sumario da categoria
        $sumario = PDF::loadView('sumario_final', ['categories' => $arr_categories]);
        $sumario->save($path . '/sumario.pdf'); // salvando pdf do sumario gerado

        // atualizando posição da página corrente
        $pagina = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($path . '/sumario.pdf')), $dummy) + preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $this->user->pdf_fixo))), $dummy);

        // criando array de categorias para inserir na coluna lateral de cada página gerada
        $arr_columns_categories = array_chunk($arr_categories, 5);
        // marcando arrays como não visitados
        foreach ($arr_columns_categories as $key1 => $multiple_categories) {
            foreach ($multiple_categories as $key2 => $actual_category) {
                $arr_columns_categories[$key1][$key2]['marked'] = false;
            }
        }

        // gerando pdfs das categorias
        foreach ($categories as $category) {
            gc_disable();

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

            // gerando pdf da categoria com paginação
            $pdf = PDF::loadView('index_final', ['categories' => $category, 'categories_column' => $arr_categories_in_column[0], 'page' => $pagina]);
            // return $pdf->stream('catalogo_final.pdf');

            $fileName =  $category->title . '.' . 'pdf';

            $pdf->save($path . '/' . $fileName);
            array_push($pdfs, $path . '/' . $fileName); // guardar pdf da categoria no array final

            // ajustando contagem de páginas para inserir a pagina atual correta no proximo loop
            foreach ($category->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
                if ($pagina == ($pagina - 1)) {
                    $pagina += (int)($subcategory->products()->count() / ($pagina - 2)) + 1;
                    continue;
                }
                $pagina += (int)($subcategory->products()->count() / 9) + 1;
            }

            gc_enable();
            gc_collect_cycles();
        }

        // anexar todas as categorias em um unico arquivo
        $pdfMerger = PDFMerger::init();
        $pdfMerger->addPDF(public_path('storage' . $this->user->pdf_fixo), 'all'); // anexando as paginas fixas
        $pdfMerger->addPDF(public_path('storage/tmp/sumario.pdf'), 'all'); // anexando sumario criado
        foreach ($pdfs as $newpdf) {
            $numPages = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($newpdf)), $dummy) - 1;
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
