<?php

namespace App\Http\Controllers;

use App\Customs\Utils;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {

    }

    /**
    * Show the application home.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index(Request $request)
    {
        $data = [];

        // $galleries = Gallery::orderBy('created_at', 'desc')->get();
        $galleries = Gallery::orderBy('id', 'desc')->paginate(24);
        $data['galleries'] = $galleries;
        $data['paginator'] = [
            'currentPage' => $galleries->currentPage(),
            'totalPages' => $galleries->lastPage(),
            // idk, if the URI need its own logic so that later on
            // if needed when a new request var is added it can be append to the URI
            'uri' => "/?page=",
            'lastPage' => $galleries->lastPage(),
        ];
        return view('main.home', $data);
    }

    public function help()
    {
        return view('main.help');
    }
}
