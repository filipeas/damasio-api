<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class UserController extends Controller
{
    /**
     * Método responsável por mostrar tela home da loja.
     */
    public function home()
    {
        return view('dashboard.index');
    }

    /**
     * Método responsável por mostrar tela home da loja.
     */
    public function config()
    {
        return view('dashboard.config');
    }

    /**
     * Método responsável por atualizar PDF's da configuração do sistema
     */
    public function executeConfig(Request $request)
    {
        $output = [];

        if ($request->has('pdf_fixo')) {
            $output[] = [
                'name' => 'pdf_fixo',
                'filename' => $request->file('pdf_fixo')->getClientOriginalName(),
                'Mime-Type' => $request->file('pdf_fixo')->getClientMimeType(),
                'contents' => fopen($request->file('pdf_fixo')->path(), 'r'),
            ];
        }

        if ($request->has('pdf_completo')) {
            $output[] = [
                'name' => 'pdf_completo',
                'filename' => $request->file('pdf_completo')->getClientOriginalName(),
                'Mime-Type' => $request->file('pdf_completo')->getClientMimeType(),
                'contents' => fopen($request->file('pdf_completo')->path(), 'r'),
            ];
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(env('API_URL') . "/api/user/config/pdf", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $request->session()->get('token'),
                ],
                'multipart' => $output,
            ]);

            $data = json_decode($response->getBody()->getContents());

            $request->session()->put('user', $data->data->user);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect()->route('logout')->with('message', json_decode($e->getResponse()->getBody()->getContents())->message);
            } else if ($e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('user.config')->with([
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

        return redirect()->route('user.config');
    }
}
