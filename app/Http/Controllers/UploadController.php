<?php

namespace App\Http\Controllers;

use App\Customs\Utils;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    /**
     * something something
     *
     */
    public function index()
    {
        $data = [];
        if (Auth::check()) {

        }
        // TODO: add error message handling
        return redirect()->route('home');
    }
}
