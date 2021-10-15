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

    // /**
    //  * [TESTE]
    //  * Método que printa exemplar de uma categoria no navegador.
    //  */
    // public function showCatalog()
    // {
    //     $user = User::where('id', 1)->first();

    //     $categories = Category::whereNull('parent')->orderBy('title', 'ASC')->get();

    //     // pdfs gerados. é usado para fazer merge de todos os pdfs gerados no final
    //     $pdfs = [];

    //     // caminhos fixos
    //     $path = public_path('storage/tmp'); // diretorio que guardará o pdf da subcategoria

    //     // nº de páginas do PDF fixo
    //     $pagina = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $user->pdf_fixo))), $dummy); //  + 2

    //     // gerando pdf do sumário (gerar a primeira vez para calcular a quantidade de paginas)
    //     $arr_categories = [];
    //     foreach ($categories as $category) {
    //         $arr_pages = [];
    //         foreach ($category->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
    //             array_push($arr_pages, [$subcategory->title => $pagina]);
    //         }
    //         array_push($arr_categories, ['subcategories' => $arr_pages, 'category' => $category->title, 'color' => $this->random_color()]);
    //     }

    //     // gerando pdf do sumario da categoria
    //     $sumario = PDF::loadView('sumario_final', ['categories' => $arr_categories, 'page' => $pagina]);
    //     // return $sumario->stream('sumario_final.pdf');
    //     $sumario->save($path . '/sumario.pdf'); // salvando pdf do sumario gerado

    //     // atualizando posição da página corrente
    //     $paginasDoSumario = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($path . '/sumario.pdf')), $dummy) - 1;
    //     $pagina = $paginasDoSumario + preg_match_all("/\/Page\W/", utf8_encode(file_get_contents(public_path('storage' . $user->pdf_fixo))), $dummy);

    //     // criando array de categorias para inserir na coluna lateral de cada página gerada
    //     $arr_columns_categories = array_chunk($arr_categories, 8);
    //     // marcando arrays como não visitados
    //     foreach ($arr_columns_categories as $key1 => $multiple_categories) {
    //         foreach ($multiple_categories as $key2 => $actual_category) {
    //             $arr_columns_categories[$key1][$key2]['marked'] = false;
    //         }
    //     }

    //     // reseta array de categorias para montar o sumário final
    //     $arr_categories = [];

    //     // gerando pdfs das categorias
    //     foreach ($categories as $key => $category) {
    //         if ($key > 4) {
    //             continue;
    //         }
    //         // reseta o array de paginas de subcategorias para montar o sumário final
    //         $arr_pages = [];

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

    //         if ($category->propaganda != '')
    //             array_push($pdfs, public_path('storage' . $category->propaganda)); // guardar pdf da propaganda da subcategoria no array final

    //         // percorrer subcategorias da categoria atual
    //         foreach ($category->subcategories()->orderBy('title', 'ASC')->get()
    //             as $key => $subcategory) {
    //             // if ($key != 15)
    //             //     continue;
    //             // atualizando numero de paginas do sumario
    //             array_push($arr_pages, [$subcategory->title => $pagina]);

    //             gc_disable();
    //             if ($category->model == 1) {
    //                 $pdf = PDF::loadView('layout_lista', [
    //                     'subcategory' => $subcategory,
    //                     'categories_column' => $arr_categories_in_column[0],
    //                     'page' => $pagina - 1,
    //                 ]);
    //             } elseif ($category->model == 0) {
    //                 $pdf = PDF::loadView('layout_bloco', [
    //                     'subcategory' => $subcategory,
    //                     'categories_column' => $arr_categories_in_column[0],
    //                     'page' => $pagina - 1,
    //                 ]);
    //             } else {
    //                 $pdf = PDF::loadView('layout_lista', [
    //                     'subcategory' => $subcategory,
    //                     'categories_column' => $arr_categories_in_column[0],
    //                     'page' => $pagina - 1,
    //                 ]);
    //             }

    //             // return $pdf->stream('catalogo_final.pdf'); // retornar view da subcategoria gerada
    //             $fileName =  $subcategory->title . '_subcategoria_' . time() . '.' . 'pdf';

    //             $pdf->save($path . '/' . $fileName);
    //             array_push($pdfs, $path . '/' . $fileName); // guardar pdf da subcategoria no array final

    //             // ajustando contagem de páginas para inserir a pagina atual correta no proximo loop
    //             $paginasDoPDFAtual = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($path . '/' . $fileName)), $dummy);
    //             $pagina += ($paginasDoPDFAtual == 1 ? $paginasDoPDFAtual : ($paginasDoPDFAtual - 1));

    //             gc_enable();
    //             gc_collect_cycles();
    //         }

    //         // array das categorias para o sumário
    //         array_push($arr_categories, ['subcategories' => $arr_pages, 'category' => $category->title, 'color' => $this->random_color()]);
    //         // break;
    //     }

    //     // gerando pdf final do sumario
    //     $sumario = PDF::loadView('sumario_final', ['categories' => $arr_categories, 'page' => $pagina]);
    //     $sumario->save($path . '/sumario.pdf'); // salvando pdf do sumario gerado

    //     // anexação final (juntando todas as categorias em um único arquivo)
    //     // anexar todas as categorias em um unico arquivo
    //     $pdfMerger = PDFMerger::init();
    //     $pdfMerger->addPDF(public_path('storage' . $user->pdf_fixo), 'all'); // anexando as paginas fixas
    //     $pdfMerger->addPDF(public_path('storage/tmp/sumario.pdf'), 'all'); // anexando sumario criado
    //     foreach ($pdfs as $newpdf) {
    //         $numPages = preg_match_all("/\/Page\W/", utf8_encode(file_get_contents($newpdf)), $dummy) - 1;
    //         if ($numPages === 0)
    //             $numPages = 1;
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

    // // gerando cores aleatorias para os titulos das categorias no sumario
    // function random_color_part()
    // {
    //     return str_pad(dechex(mt_rand(0, 155)), 2, '0', STR_PAD_LEFT);
    // }

    // function random_color()
    // {
    //     return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    // }
}
