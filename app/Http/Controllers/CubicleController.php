<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CubicleController extends Controller
{
    public function index()
    {
        return view('cubicles.create');
    }
}
