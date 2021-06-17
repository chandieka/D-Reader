<?php

namespace App\Http\Controllers;

use App\Customs\Utils;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        return view('help');
    }
}
