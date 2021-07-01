<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdenesController extends Controller
{
    public function index()
    {
        return view('ordenes');
    }


    public function nuevaorden()
    {
        return view('nuevaorden');
    }
}
