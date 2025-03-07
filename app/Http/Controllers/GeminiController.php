<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeminiController extends Controller
{
    public function showConsultPage()
    {
        return view('ai-consult');
    }

    public function generateResponse()
    {

    }
}
