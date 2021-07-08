<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if(!session('usuario')['login'])
        {
            return redirect(url('/'));
        }

        $data['productos_bajostock']   = DB::select("SELECT p.*  , tp.Nombre_TProd as tipo_producto
                                                    FROM producto AS p JOIN tipo_producto as tp on tp.ID_TProd = p.ID_TProd
                                                    WHERE p.StockActual_Prod <= 70");
        return view('home' , $data);
    }
}
