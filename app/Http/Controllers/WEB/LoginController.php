<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class LoginController extends Controller
{
    /**
     * Método responsável por mostrar tela de login.
     */
    public function formLogin()
    {
        return view('dashboard.login');
    }

    /**
     * Método responsável por realizar requisição de login a API.
     */
    public function login(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post(env('API_URL') . '/api/login', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => $request->all()
            ]);

            $data = json_decode($response->getBody()->getContents())->data;
            $request->session()->put('token', $data->token);
            $request->session()->put('user', $data->user);
            $request->session()->put('accessed_by', $data->accessed_by);

            return redirect()->route('user.home')->with('message', 'Bem-vindo, ' . $data->user->name == null ? $data->user->store_name : $data->user->name);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                return view('dashboard.login', [
                    'errorParameters' => false,
                    'message' => [
                        json_decode($e->getResponse()->getBody()->getContents())->message
                    ],
                ]);
            } else if ($e->getResponse()->getStatusCode() == 422) {
                return view('dashboard.login', [
                    'errorParameters' => true,
                    'message' => [
                        json_decode($e->getResponse()->getBody()->getContents())->errors,
                    ],
                ]);
            }
        }
    }

    /**
     * Método responsável por realizar requisição de logout a API.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('token');
        $request->session()->forget('user');
        $request->session()->forget('accessed_by');

        return redirect()->route('login');
    }
}
