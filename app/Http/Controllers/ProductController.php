<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // ← ⭐️忘れないでね

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // productsテーブルの全データを取得
        return view('products', compact('products'));
    }
}
