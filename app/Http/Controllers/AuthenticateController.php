<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

class AuthenticateController extends Controller
{
    public function login(Request $request) {
        $rules = [
            'name'  => 'required|string|max:255',
            'password' => 'required|string|min:6'     
            ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }    
    
            if (Auth::attempt(['name' => $request->name, 'password' => $request->password , 'activo' => 1 ,'acceso' => true])) {
                $request->session()->regenerate();
                $id = Auth::id();
                $user = User::with('__empleado','perfile','__empleado.sedes')->where('id',$id)->get();
/*                 $user = User::with('empleado','empleado.perfil')->where('id',$id)->get();
    
                if($user[0]->empleado->habilitado == 0){
                    Auth::logout();
                    return response()->json(['logging' => 0 , 'error' => 'El Usuario esta deshabilitado ... consulte con el Area de sistemas !!!'], 401);
                } */
             
                return response()->json(["logging" => 1 , "user" => $user]);     
            }
    
            return response()->json(['logging' => 0 , 'error' => 'Usuario y/o Password son incorrectos !!!'], 401);
               
    }

    //funcion de login username
    public function username()
    {
        return 'name';
    }

    public function logout() {
        Auth::logout();
    }
}
