<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Login;
use App\Http\Resources\User as ResourcesUser;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * Método responsável por realizar login.
     * 
     * POST METHOD
     */
    public function login(Login $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::find(Auth::user()->id);

            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user'] = new ResourcesUser($user);
                $success['accessed_by'] = 'user';

            return $this->sendResponse($success, 'Login realizado com sucesso.');
        } else {
            return $this->sendError('Não autorizado.');
        }
    }

    /**
     * Método responsável por realizar logout.
     * 
     * GET METHOD
     */
    public function logout()
    {
        Auth::logout();

        return $this->sendResponse(['logout' => true], 'Logout realizado com sucesso.');
    }
}
