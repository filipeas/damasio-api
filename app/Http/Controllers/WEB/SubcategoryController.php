<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class SubcategoryController extends Controller
{
    /**
     * Método responsável por retornar view de visualização de todas as categorias.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/user/category/{$category}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('dashboard.subcategory.index', [
                'category' => $data->data->category,
                'subcategories' => $data->data->category->subcategories,
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            }

            return view('dashboard.category.index', [
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
     * Método responsável por mostrar subcategorias da categoria.
     */
    public function show(Request $request, int $subcategory)
    {
        $page = 1;
        if ($request->has('page'))
            $page = $request->page;

        $search = "";
        if ($request->has('search')) {
            $search = $request->search;
            $url = "/api/user/subcategory/{$subcategory}?search={$search}&page={$page}";
        } else {
            $url = "/api/user/subcategory/{$subcategory}?page={$page}";
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('dashboard.product.index', [
                'subcategory' => $data->data->subcategory,
                'products' => $data->data->subcategory->products,
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            }

            return view('dashboard.category.index', [
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
     * Método responsável por mostrar tela de cadastrar categoria.
     */
    public function create(Request $request, int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/user/category/{$category}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('dashboard.subcategory.create', [
                'category' => $data->data->category,
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            }

            return view('dashboard.category.index', [
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

    /**
     * Método responsável por mostrar tela de edição da categoria.
     */
    public function edit(Request $request, int $subcategory)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/user/subcategory/{$subcategory}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('dashboard.subcategory.edit', [
                'subcategory' => $data->data->subcategory,
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            }

            return redirect()->route('user.subcategory.index', ['category' => $data->data->subcategory->category->id])->with([
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
     * Método responsável por atualizar categoria na API.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $subcategory, int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->put(env('API_URL') . "/api/user/subcategory/{$subcategory}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'form_params' => $request->all(),
            ]);

            $data = json_decode($response->getBody()->getContents());

            return redirect()->route('user.subcategory.index', ['category' => $category]);
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
                ],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $subcategory, int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->delete(env('API_URL') . "/api/user/subcategory/{$subcategory}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            json_decode($response->getBody()->getContents());

            return redirect()->route('user.subcategory.index', ['category' => $category]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
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
    }
}
