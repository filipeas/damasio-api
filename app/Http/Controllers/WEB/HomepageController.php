<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Controller as Controller;

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
}
