<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class BrandController extends Controller
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
            $response = $client->get(env('API_URL') . "/api/user/brand", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('dashboard.brand.index', [
                'error' => false,
                'brands' => $data->data->brands,
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
     * Método responsável por mostrar tela de cadastrar marca.
     */
    public function create()
    {
        return view('dashboard.brand.create');
    }

    /**
     * Método responsável por cadastrar marca pela API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $output = [
            [
                'name' => 'image',
                'filename' => $request->file('image')->getClientOriginalName(),
                'Mime-Type' => $request->file('image')->getClientMimeType(),
                'contents' => fopen($request->file('image')->path(), 'r'),
            ]
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(env('API_URL') . '/api/user/brand', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'form_params' => $request->all(),
            ]);

            $data1 = json_decode($response->getBody()->getContents());

            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->post(env('API_URL') . "/api/user/brand/{$data1->data->brand->id}/image", [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $request->session()->get('token'),
                    ],
                    'multipart' => $output,
                ]);

                json_decode($response->getBody()->getContents());

                return redirect()->route('user.brand.index');
            } catch (ClientException $e) {
                if ($e->getResponse()->getStatusCode() == 401) {
                    return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
                } else if ($e->getResponse()->getStatusCode() == 404) {
                    return redirect()->route('user.brand.index')->with([
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
                return redirect()->route('user.brand.index')->with([
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
     * Método responsável por mostrar tela de edição da marca.
     */
    public function edit(Request $request, int $brand)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . "/api/user/brand/{$brand}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return view('dashboard.brand.edit', [
                'brand' => $data->data->brand,
            ]);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            }

            return view('dashboard.brand.index', [
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
     * Método responsável por atualizar marca pela API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $brand)
    {
        $output = [];

        if ($request->has('image')) {
            $output[] =
                [
                    'name' => 'image',
                    'filename' => $request->file('image')->getClientOriginalName(),
                    'Mime-Type' => $request->file('image')->getClientMimeType(),
                    'contents' => fopen($request->file('image')->path(), 'r'),
                ];
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->put(env('API_URL') . "/api/user/brand/{$brand}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'form_params' => $request->all(),
            ]);

            $data1 = json_decode($response->getBody()->getContents());

            if ($request->has('image')) {
                try {
                    $client = new \GuzzleHttp\Client();
                    $response = $client->post(env('API_URL') . "/api/user/brand/{$brand}/image", [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . $request->session()->get('token'),
                        ],
                        'multipart' => $output,
                    ]);

                    json_decode($response->getBody()->getContents());

                    return redirect()->route('user.brand.index');
                } catch (ClientException $e) {
                    if ($e->getResponse()->getStatusCode() == 401) {
                        return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
                    } else if ($e->getResponse()->getStatusCode() == 404) {
                        return redirect()->route('user.brand.index')->with([
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
            } else {
                return redirect()->route('user.brand.index');
            }
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('user.brand.index')->with([
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
    public function destroy(Request $request, int $brand)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->delete(env('API_URL') . "/api/user/brand/{$brand}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
            ]);

            json_decode($response->getBody()->getContents());

            return redirect()->route('user.brand.index');
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('user.brand.index')->with([
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
