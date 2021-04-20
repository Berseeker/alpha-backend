<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends ApiController
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation' => 'required|same:password'
        ];

        $messages = [
            'name.required' => 'Es necesario agregar un nombre',
            'email.required' => 'Es necesario agregar un email',
            'email.email' => 'Formato invalido',
            'password.required' => 'Es necesario agregar un password',
            'password.confirmed' => 'Ingresa nuevamente tu password',
            'password.regex' => 'La password debe contener 1 mayuscula, 1 minuscula, 1 digito y un caracter especial',
            'password_confirmation.required' => 'Ingresa nuevamente tu password',
            'password_confirmation.same' => 'Las passwords no coinciden' 
        ];

        $this->validate($request,$rules,$messages);
        
        $user = User::where('email',$request->email)->get();
   
        if($user->isEmpty())
        {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return $this->successResponse('El usuario se registro exitosamente',$user,201);
        }
        
        return $this->errorResponse('El mail ya se encuentra registrado',409);
    }
}
