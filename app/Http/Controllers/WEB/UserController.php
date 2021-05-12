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
}
