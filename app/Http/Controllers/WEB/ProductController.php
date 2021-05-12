<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class ProductController extends Controller
{
    /**
     * Método responsável por mostrar tela de cadastrar categoria.
     */
    public function create(Request $request, int $subcategory, int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/user/brand", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            $data1 = json_decode($response->getBody()->getContents());

            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->get(env('API_URL') . "/api/user/subcategory/{$subcategory}", [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $request->session()->get('token'),
                    ],
                ]);

                $data2 = json_decode($response->getBody()->getContents());

                return view('dashboard.product.create', [
                    'brands' => $data1->data->brands,
                    'subcategory' => $data2->data->subcategory,
                ]);
            } catch (ClientException $e) {
                if ($e->getResponse()->getStatusCode() == 401) {
                    return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
                }

                return redirect()->route('user.subcategory.index', ['category' => $category])->with([
                    'error' => true,
                    'message' => [
                        [
                            [json_decode($e->getResponse()->getBody()->getContents())->message],
                        ],
                    ]
                ]);
            }
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            }

            return redirect()->route('user.subcategory.index', ['category' => $category])->with([
                'error' => true,
                'message' => [
                    [
                        [json_decode($e->getResponse()->getBody()->getContents())->message],
                    ],
                ]
            ]);
        }
    }

    /**
     * Método responsável por cadastrar categoria pela API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(env('API_URL') . '/api/user/subcategory', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'form_params' => $request->all(),
            ]);

            json_decode($response->getBody()->getContents());

            return redirect()->route('user.category.show', ['category' => $category]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('user.category.index')->with([
                    'error' => true,
                    'message' => [
                        [
                            [json_decode($e->getResponse()->getBody()->getContents())->message],
                        ],
                    ],
                ]);
            } else if ($e->getResponse()->getStatusCode() == 422) {
                return redirect()->back()->withInput()->with([
                    'error' => true,
                    'message' => [
                        json_decode($e->getResponse()->getBody()->getContents())->errors,
                    ],
                ]);
            }
        }
    }
}
