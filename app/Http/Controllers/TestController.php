<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $data[] = Auth::user();
        return view('prototype.random', $data);
    }

    public function favorite(Request $request) {
        if (Auth::check()){

            return ["status" => "OK"];
        }
        return ["status" => "BAD"];
    }
}
