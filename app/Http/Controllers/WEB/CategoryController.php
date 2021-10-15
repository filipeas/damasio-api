<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class CategoryController extends Controller
{
    /**
     * Método responsável por retornar view de visualização de todas as categorias.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/user/category", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('dashboard.category.index', [
                'error' => false,
                'categories' => $data->data->categories,
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
    public function show(Request $request, int $category)
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
     * Método responsável por mostrar tela de cadastrar categoria.
     */
    public function create()
    {
        return view('dashboard.category.create');
    }

    /**
     * Método responsável por cadastrar categoria pela API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $output = [
            [
                'name' => 'title',
                'contents' => $request->input('title'),
            ]
        ];

        if ($request->has('color')) {
            $output[] = [
                'name' => 'color',
                'contents' => $request->input('color'),
            ];
        };

        if ($request->has('title_color')) {
            $output[] = [
                'name' => 'title_color',
                'contents' => $request->input('title_color'),
            ];
        }

        if ($request->has('model')) {
            $output[] = [
                'name' => 'model',
                'contents' => $request->input('model'),
            ];
        }

        if ($request->hasFile('propaganda')) {
            $output[] = [
                'name' => 'propaganda',
                'filename' => $request->file('propaganda')->getClientOriginalName(),
                'Mime-Type' => $request->file('propaganda')->getClientMimeType(),
                'contents' => fopen($request->file('propaganda')->path(), 'r'),
            ];
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(env('API_URL') . '/api/user/category', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'multipart' => $output,
            ]);

            json_decode($response->getBody()->getContents());

            return redirect()->route('user.category.index');
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
    public function edit(Request $request, int $category)
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

            return view('dashboard.category.edit', [
                'category' => $data->data->category,
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            }

            return redirect()->route('user.category.index')->with([
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
    public function update(Request $request, int $category)
    {
        $output = [
            [
                'name' => 'title',
                'contents' => $request->input('title'),
            ]
        ];

        if ($request->has('color')) {
            $output[] = [
                'name' => 'color',
                'contents' => $request->input('color'),
            ];
        };

        if ($request->has('title_color')) {
            $output[] = [
                'name' => 'title_color',
                'contents' => $request->input('title_color'),
            ];
        }

        if ($request->has('model')) {
            $output[] = [
                'name' => 'model',
                'contents' => $request->input('model'),
            ];
        }

        if ($request->hasFile('propaganda')) {
            $output[] = [
                'name' => 'propaganda',
                'filename' => $request->file('propaganda')->getClientOriginalName(),
                'Mime-Type' => $request->file('propaganda')->getClientMimeType(),
                'contents' => fopen($request->file('propaganda')->path(), 'r'),
            ];
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(env('API_URL') . "/api/user/category/{$category}/updatecategory", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'multipart' => $output,
            ]);

            $data = json_decode($response->getBody()->getContents());

            return redirect()->route('user.category.index');
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            }

            return redirect()->route('user.category.edit', ['category' => $category])->with([
                'error' => true,
                'message' => [
                    [
                        [json_decode($e->getResponse()->getBody()->getContents())->errors],
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
    public function destroy(Request $request, int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->delete(env('API_URL') . "/api/user/category/{$category}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            json_decode($response->getBody()->getContents());

            return redirect()->route('user.category.index');
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
                    ]
                ]);
            }
        }
    }
}
