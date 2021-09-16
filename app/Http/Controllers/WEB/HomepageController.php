<?php

namespace App\Http\Controllers\WEB;

use App\Category;
use Illuminate\Http\Request;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Controller as Controller;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Filesystem\Filesystem;

class HomepageController extends Controller
{
    public function home()
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/show-all-categories", [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('site/index', [
                'error' => false,
                'catalog' => $data->data->user->pdf_completo,
                'categories' => $data->data->categories,
            ]);
        } catch (ClientException $e) {
            return view('site/index', [
                'catalog' => null,
                'categories' => [],
                'error' => true,
                'message' => "Estamos com problemas em mostrar os nossos produtos. Não se preocupe, já estamos consertando e em breve estará tudo normal",
            ]);
        }
    }

    public function showCategory(int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/category/{$category}/show", [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('site/category', [
                'category' => $data->data->category
            ]);
        } catch (ClientException $e) {
            return view('site/index', [
                'error' => true,
                'message' => [
                    [
                        [json_decode($e->getResponse()->getBody()->getContents())->message],
                    ],
                ],
            ]);
        }
    }

    public function showSubcategory(Request $request, int $subcategory)
    {
        $page = 1;
        if ($request->has('page'))
            $page = $request->page;

        $search = "";
        if ($request->has('search')) {
            $search = $request->search;
            $url = "/api/subcategory/{$subcategory}/show?search={$search}&page={$page}";
        } else {
            $url = "/api/subcategory/{$subcategory}/show?page={$page}";
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . $url, [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('site/subcategory', [
                'subcategory' => $data->data->subcategory
            ]);
        } catch (ClientException $e) {
            return view('site/category', [
                'error' => true,
                'message' => [
                    [
                        [json_decode($e->getResponse()->getBody()->getContents())->message],
                    ],
                ],
            ]);
        }
    }

    public function showProduct(int $product)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/product/{$product}/show", [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('site/product', [
                'product' => $data->data->product
            ]);
        } catch (ClientException $e) {
            return view('site/subcategory', [
                'error' => true,
                'message' => [
                    [
                        [json_decode($e->getResponse()->getBody()->getContents())->message],
                    ],
                ],
            ]);
        }
    }

    /**
     * [TESTE]
     * Método que printa exemplar de uma categoria no navegador.
     */
    public function showCatalog()
    {
        $user = User::where('id', 1)->first();

        $categories = Category::whereNull('parent')->orderBy('title', 'ASC')->get();

        $pagina = 0;

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

        // criando array de categorias para inserir na coluna lateral de cada página gerada
        $arr_columns_categories = array_chunk($arr_categories, 8);
        // marcando arrays como não visitados
        foreach ($arr_columns_categories as $key1 => $multiple_categories) {
            foreach ($multiple_categories as $key2 => $actual_category) {
                $arr_columns_categories[$key1][$key2]['marked'] = false;
            }
        }

        // gerando pdfs das categorias
        foreach ($categories as $category) {
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
            $pdf = PDF::loadView('index_teste', [
                'category' => $category,
                'categories_column' => $arr_categories_in_column[0],
                'page' => 0
            ]);

            return $pdf->stream('catalogo_final.pdf');
        }
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

    // (TESTES) - REMOVER
    /**
     * Método responsável por gerar o PDF na tela do navegador
     */
    // public function showCatalog()
    // {
    //     $user = User::where('id', 1)->first();
    //     /**
    //      * Método responsável por gerar PDF's das categorias a partir do banco de dados.
    //      * Esse método cria os pdfs das categorias e armazena em um array e, no final,
    //      * junta todos em um unico arquivo.
    //      */

    //     // retornando categorias na ordem algabetica
    //     $categories = Category::whereNull('parent')->orderBy('title', 'ASC')->get();

    //     // antes de enviar ao job, deve ser verificado se há categorias para ser processado
    //     if ($categories->isEmpty()) {
    //         return response()->json('Não há categorias para processar', 200);
    //     }

    //     // pdfs gerados. é usado para fazer merge de todos os pdfs gerados no final
    //     $pdfs = [];

    //     // caminhos fixos
    //     $path = public_path('storage/tmp'); // diretorio que guardará o pdf da categoria

    //     // nº de páginas do PDF fixo
    //     $pagina = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $user->pdf_fixo))), $dummy) + 2;

    //     // gerando pdf do sumário
    //     $arr_categories = [];
    //     foreach ($categories as $category) {
    //         $arr_pages = [];
    //         foreach ($category->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
    //             if ($pagina == ($pagina - 1)) {
    //                 array_push($arr_pages, [$subcategory->title => $pagina]);
    //                 $pagina += (int)($subcategory->products()->count() / ($pagina - 2)) + 1;
    //                 continue;
    //             }
    //             array_push($arr_pages, [$subcategory->title => $pagina]);
    //             $pagina += (int)($subcategory->products()->count() / 9) + 1;
    //         }
    //         array_push($arr_categories, ['subcategories' => $arr_pages, 'category' => $category->title, 'color' => $this->random_color()]);
    //     }

    //     // gerando pdf do sumario da categoria
    //     $sumario = PDF::loadView('sumario_final', ['categories' => $arr_categories]);
    //     $sumario->save($path . '/sumario.pdf'); // salvando pdf do sumario gerado

    //     // atualizando posição da página corrente
    //     $pagina = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($path . '/sumario.pdf')), $dummy) + preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $user->pdf_fixo))), $dummy);

    //     // criando array de categorias para inserir na coluna lateral de cada página gerada
    //     $arr_columns_categories = array_chunk($arr_categories, 5);
    //     // marcando arrays como não visitados
    //     foreach ($arr_columns_categories as $key1 => $multiple_categories) {
    //         foreach ($multiple_categories as $key2 => $actual_category) {
    //             $arr_columns_categories[$key1][$key2]['marked'] = false;
    //         }
    //     }

    //     // gerando pdfs das categorias
    //     foreach ($categories as $category) {
    //         gc_disable();

    //         // marcando arrays como não visitados
    //         $arr_categories_in_column = [];
    //         foreach ($arr_columns_categories as $key1 => $multiple_categories) {
    //             foreach ($multiple_categories as $key2 => $actual_category) {
    //                 if ($arr_columns_categories[$key1][$key2]['category'] == $category->title) {
    //                     $arr_columns_categories[$key1][$key2]['marked'] = true;
    //                     array_push($arr_categories_in_column, $arr_columns_categories[$key1]);
    //                 } else {
    //                     $arr_columns_categories[$key1][$key2]['marked'] = false;
    //                 }
    //             }
    //         }

    //         // gerando pdf da categoria com paginação
    //         $pdf = PDF::loadView('index_final', ['categories' => $category, 'categories_column' => $arr_categories_in_column[0], 'page' => $pagina]);
    //         // return $pdf->stream('catalogo_final.pdf');

    //         $fileName =  $category->title . '.' . 'pdf';

    //         $pdf->save($path . '/' . $fileName);
    //         array_push($pdfs, $path . '/' . $fileName); // guardar pdf da categoria no array final

    //         // ajustando contagem de páginas para inserir a pagina atual correta no proximo loop
    //         foreach ($category->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
    //             if ($pagina == ($pagina - 1)) {
    //                 $pagina += (int)($subcategory->products()->count() / ($pagina - 2)) + 1;
    //                 continue;
    //             }
    //             $pagina += (int)($subcategory->products()->count() / 9) + 1;
    //         }

    //         gc_enable();
    //         gc_collect_cycles();
    //     }

    //     // anexar todas as categorias em um unico arquivo
    //     $pdfMerger = PDFMerger::init();
    //     $pdfMerger->addPDF(public_path('storage' . $user->pdf_fixo), 'all'); // anexando as paginas fixas
    //     $pdfMerger->addPDF(public_path('storage/tmp/sumario.pdf'), 'all'); // anexando sumario criado
    //     foreach ($pdfs as $newpdf) {
    //         $numPages = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($newpdf)), $dummy) - 1;
    //         $pdfMerger->addPDF($newpdf, "1-{$numPages}"); // anexando pdfs das categorias
    //     }
    //     $pdfMerger->merge();
    //     $pdfMerger->save(public_path('storage/pdfs/catalogo_completo.pdf'), "file");

    //     // salvar caminho do PDF na categoria do banco de dados
    //     // $user->pdf_completo = 'pdfs/catalogo_completo.pdf';
    //     // $user->save();

    //     // limpando diretório temporario
    //     $file = new Filesystem;
    //     $file->cleanDirectory(public_path('storage/tmp'));
    //     dd('processo finalizado com sucesso');
    // }
}
