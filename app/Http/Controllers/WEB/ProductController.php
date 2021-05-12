<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class ProductController extends Controller
{
    /**
     * Método responsável por mostrar um produto.
     */
    public function show(Request $request, int $product, int $category)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/user/product/{$product}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('dashboard.product.show', [
                'product' => $data->data->product
            ]);
        } catch (ClientException $e) {
            dd($e->getResponse()->getStatusCode());
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
     * Método responsável por mostrar tela de cadastrar produto.
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
     * Método responsável por cadastrar produto pela API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $subcategory)
    {
        $output = [
            [
                'name' => 'cover',
                'filename' => $request->file('cover')->getClientOriginalName(),
                'Mime-Type' => $request->file('cover')->getClientMimeType(),
                'contents' => fopen($request->file('cover')->path(), 'r'),
            ]
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(env('API_URL') . '/api/user/product', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'form_params' => $request->all(),
            ]);

            $data1 = json_decode($response->getBody()->getContents());

            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->post(env('API_URL') . "/api/user/product/{$data1->data->product->id}/image", [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $request->session()->get('token'),
                    ],
                    'multipart' => $output,
                ]);

                json_decode($response->getBody()->getContents());

                return redirect()->route('user.subcategory.show', ['subcategory' => $subcategory]);
            } catch (ClientException $e) {
                if ($e->getResponse()->getStatusCode() == 401) {
                    return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
                } else if ($e->getResponse()->getStatusCode() == 404) {
                    return redirect()->back()->withInput()->with([
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
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->back()->withInput()->with([
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
     * Método responsável por mostrar tela de editar produto.
     */
    public function edit(Request $request, int $product, int $category, int $subcategory)
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

                try {
                    $client = new \GuzzleHttp\Client();
                    $response = $client->get(env('API_URL') . "/api/user/product/{$product}", [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . $request->session()->get('token'),
                        ],
                    ]);

                    $data3 = json_decode($response->getBody()->getContents());

                    return view('dashboard.product.edit', [
                        'product' => $data3->data->product,
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
     * Método responsável por atualizar produto pela API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $product, int $subcategory)
    {
        $output = [];

        if ($request->has('cover')) {
            $output[] =
                [
                    'name' => 'cover',
                    'filename' => $request->file('cover')->getClientOriginalName(),
                    'Mime-Type' => $request->file('cover')->getClientMimeType(),
                    'contents' => fopen($request->file('cover')->path(), 'r'),
                ];
        }

        try {
            $client = new \GuzzleHttp\Client();
            $client->put(env('API_URL') . "/api/user/product/{$product}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'form_params' => $request->all(),
            ]);

            // se tiver imagem para atualizar...
            if ($request->has('cover')) {
                try {
                    $client = new \GuzzleHttp\Client();
                    $client->post(env('API_URL') . "/api/user/product/{$product}/image", [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . $request->session()->get('token'),
                        ],
                        'multipart' => $output,
                    ]);
                } catch (ClientException $e) {
                    if ($e->getResponse()->getStatusCode() == 401) {
                        return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
                    } else if ($e->getResponse()->getStatusCode() == 404) {
                        return redirect()->back()->withInput()->with([
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

            // se tiver marcas para atualizar...
            if ($request->has('brands')) {
                try {
                    $client = new \GuzzleHttp\Client();
                    $client->post(env('API_URL') . "/api/user/product/{$product}/brands", [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . $request->session()->get('token'),
                        ],
                        'form_params' => $request->all(),
                    ]);
                } catch (ClientException $e) {
                    if ($e->getResponse()->getStatusCode() == 401) {
                        return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
                    } else if ($e->getResponse()->getStatusCode() == 404) {
                        return redirect()->back()->withInput()->with([
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

            return redirect()->route('user.subcategory.show', ['subcategory' => $subcategory]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->back()->withInput()->with([
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $product, int $subcategory)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->delete(env('API_URL') . "/api/user/product/{$product}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            json_decode($response->getBody()->getContents());

            return redirect()->route('user.subcategory.show', ['subcategory' => $subcategory]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('user.subcategory.show', ['subcategory' => $subcategory])->with([
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
