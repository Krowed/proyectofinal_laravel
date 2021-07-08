<?php

namespace App\Http\Controllers;
use App\Models\UsuarioModel;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        if(session('usuario')['login'])
        {
            return redirect(url('home'));
        }
        
        return view('login');
    }

    public function iniciarsesion(Request $request)
    {
        $email      =   $request->input('email');
        $clave      =   $request->input('clave');

        $verificar  =   UsuarioModel::where('Usuario' , $email)
                                    ->where('Clave' , $clave)
                                    ->first();


        if($verificar == NULL)
        {
            return redirect(url('/'))->with('mensaje' , 'Los datos no coinciden, intente de nuevo');
        }

        $usuario    =   [
            'idusuario'         => $verificar->ID_Usuario,
            'email'             => $verificar->Usuario,
            'idtipoempleado'    => $verificar->ID_TEmpl,
            'login'             => TRUE
        ];

        $request->session()->put('usuario' , $usuario);
        return redirect(url('home'));
    }


    public function cerrarsesion(Request $request)
    {   
        $request->session()->forget('usuario');
        return redirect(url('/'));
    }
}
