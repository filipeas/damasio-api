<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $status = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, $status);
    }

    /**
     * success response method.
     * 
     * Método responsável por retornar 200 após uma requisição, retornando
     * em especial o html renderizado para paginação e register_store para
     * encaminhar usuario para tela de cadastro de loja caso não seja.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponseAjax($result, $html, $message, $status = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'html'    => $html,
            'register_store' => route('register.store'),
            'message' => $message,
        ];


        return response()->json($response, $status);
    }

    /**
     * método que retorna uma mensagem de erro.
     * @param $error
     * @param $errorMessages
     * @param $code
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendErrorAjax($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'register_store' => url('cadastrar/loja'),
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
