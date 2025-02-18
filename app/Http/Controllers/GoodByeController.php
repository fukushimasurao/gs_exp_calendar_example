<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodByeController extends Controller
{
    public function goodBye()
    {
        return view('greeting');
    }
}
