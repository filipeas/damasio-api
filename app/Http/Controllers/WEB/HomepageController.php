<?php

namespace App\Http\Controllers\WEB;

use App\Category;
use Illuminate\Http\Request;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Controller as Controller;
use Barryvdh\DomPDF\Facade as PDF;

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
                'categories' => $data->data->categories
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

    public function showSubcategory(int $subcategory, int $page)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/subcategory/{$subcategory}/show?page={$page}", [
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
     * Método responsável por gerar o PDF na tela do navegador
     */
    public function showCatalog()
    {
        // $categories = Category::all();
        // return view('v2.index', compact('categories'));

        // retornando categorias
        $categories = Category::whereNull('parent')->orderBy('title', 'ASC')->get();

        // caso queira testar para uma categoria, aponte no vetor qual a posição.
        // por exemplo, caso queira printar somenta a primeira categoria, insira
        // no 'categories' o vetor $categories[0].

        // trecho responsável por montar pagina de sumario
        $pagina = 11; // considerando que o catalogo comeca na pagina 10
        $arr_pages = [];
        foreach ($categories[0]->subcategories()->orderBy('title', 'ASC')->get() as $subcategory) {
            // echo "{$subcategory->title} - {$pagina}";
            if ($pagina == 10) {
                array_push($arr_pages, [$subcategory->title => $pagina]);
                $pagina += (int)($subcategory->products()->count() / 9) + 1;
                continue;
            }
            array_push($arr_pages, [$subcategory->title => $pagina]);
            $pagina += (int)($subcategory->products()->count() / 9) + 1;
            // echo "<br>";
        }
        $sumario = PDF::loadView('sumario', ['category' => $categories[0], 'pages' => $arr_pages]);
        // return $sumario->stream('sumario.pdf');
        // dd($arr_pages);

        $pdf = PDF::loadView('index', ['categories' => $categories[0], 'page' => 10]);

        $path = public_path('storage/pdfs');
        $path_tmp = public_path('storage/tmp');
        $path_fixed_pages = public_path('storage/fixed pages');

        $fileName =  $categories[0]->title . '.' . 'pdf';

        $pdf->save($path . '/' . $fileName);
        $sumario->save($path_tmp . '/' . $fileName);

        $pdfMerger = PDFMerger::init();

        $pdfMerger->addPDF($path_fixed_pages . '/paginas-fixas.pdf', 'all');
        $pdfMerger->addPDF($path_tmp . '/' . $fileName, 'all');
        $pdfMerger->addPDF($path . '/' . $fileName, 'all');

        $pdfMerger->merge();
        $pdfMerger->save(public_path('storage/pdfs/' .  $fileName), "file");
        dd('processo finalizado com sucesso.');


        $pdf = PDF::loadView('index', ['categories' => $categories[0], 'page' => 0]);
        return $pdf->stream('catalogo.pdf');
    }
}
