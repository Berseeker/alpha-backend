<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends ApiController
{
    public function index(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ];

        $messages = [
            'email.required' => 'Es necesario agregar un email',
            'email.email' => 'Formato invalido',
            'password.required' => 'Es necesario agregar un password',
            'password.regex' => 'La password debe contener 1 mayuscula, 1 minuscula, 1 digito y un caracter especial'
        ];

        $this->validate($request,$rules,$messages);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) 
        {
            $token = Auth::user()->createToken('login');
            $data = [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'token' => $token->plainTextToken
            ];
            return $this->successResponse('Inicio de sesion exitoso',$data,200);
        }

        return $this->errorResponse('La contraseña proporcionada no concuerda con nuestros registros',403);
    }

    public function logout()
    {
        // Revoke all tokens...
        //Auth::user()->tokens()->delete();
        // Revoke the token that was used to authenticate the current request...
        Auth::user()->currentAccessToken()->delete();

        Auth::logout();
        return $this->successResponse('Cierre de sesion exitoso',null,200);
    }
}
