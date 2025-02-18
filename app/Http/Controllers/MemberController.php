<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ⭐️↓追加 DBを利用するための1行
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        $members = DB::select("SELECT * FROM members");
        return view('members', compact('members'));
    }
}
