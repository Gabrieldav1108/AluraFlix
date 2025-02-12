<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request){
        //dd(Auth::attempt($request->all()));
        $validator = Validator::make(
            $request->only(['email', 'password']),
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'O e-mail é obrigatório',
                'password.required' => 'A senha é obrigatória'
            ]
        );
        $validator->validate();

        $invalidCredetilsResponse = new JsonResponse([
            'message' => 'E-mail ou senha inválidos'
        ], 500);

        $credentials = $validator->validated();

        if(Auth::attempt($credentials)){
            if(is_null($user = User::firstWhere('email', $credentials['email']))){
                return $invalidCredetilsResponse;
            }

            Session::regenerate();

            return new JsonResponse([
                'message' => 'Login realizado com sucesso',
                'data' => [
                    'user' => $user      
                ]
                ]);
        }

        return $invalidCredetilsResponse;
    }
}
