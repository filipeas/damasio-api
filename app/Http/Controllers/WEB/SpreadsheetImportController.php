<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class SpreadsheetImportController extends Controller
{
    /**
     * Método responsável por mostrar tela de importar XML
     */
    public function index()
    {
        return view('dashboard.PDF.spreadsheet');
    }

    /**
     * método responsável por mostrar tela de gerar PDF
     */
    public function indexGeneratePDF()
    {
        return view('dashboard.PDF.generate');
    }

    /**
     * Método responsável por submeter XML na API
     */
    public function store(Request $request)
    {
        $output = [
            [
                'name' => 'xml',
                'filename' => $request->file('xml')->getClientOriginalName(),
                'Mime-Type' => $request->file('xml')->getClientMimeType(),
                'contents' => fopen($request->file('xml')->path(), 'r'),
            ]
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(env('API_URL') . '/api/user/import/xml', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'multipart' => $output,
            ]);

            json_decode($response->getBody()->getContents());

            return redirect()->route('user.import.xml');
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('user.import.xml')->with([
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
     * Método responsável por fazer pedido de geração de novos PDF's para a API
     */
    public function storeGeneratePDF(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . '/api/user/generate/pdf', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ]
            ]);

            json_decode($response->getBody()->getContents());

            return redirect()->route('user.generate.pdf');
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('user.generate.pdf')->with([
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
     * Método responsável por verificar progresso de geração dos PDF's
     */
    public function progressGenerate(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get(env('API_URL') . '/api/user/progress/generation/pdf', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            return response()->json($data, 200, []);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return response()->json([
                    'error' => true,
                    'message' => [
                        [
                            [json_decode($e->getResponse()->getBody()->getContents())->message],
                        ],
                    ],
                ], 404, []);
            } else if ($e->getResponse()->getStatusCode() == 422) {
                return response()->json([
                    'error' => true,
                    'message' => [
                        json_decode($e->getResponse()->getBody()->getContents())->errors,
                    ],
                ], 422, []);
            }
        }
    }
}
