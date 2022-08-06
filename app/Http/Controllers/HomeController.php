<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

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
        // $galleries = Gallery::orderBy('id', 'desc')->paginate(24); // return the latest addition of galleries
        $galleries = Gallery::with(['pages'=> function($query) {
            $query->where('page_number', '=', 1); // get the first page along with the gallery for thumnbnail
        }])->orderBy('id', 'desc')
        ->where('isHidden', '!=', 1)
        ->paginate(24);

        // dd(public_path('assets/galleries') . '/' . $galleries[0]->dir_path . '/' . $galleries[0]->pages[0]->filename);

        $data['galleries'] = $galleries;

        // metadata for paginator
        $data['paginator'] = [
            'currentPage' => $galleries->currentPage(),
            'totalPages' => $galleries->lastPage(),
            'uri' => route('home') . "/?page=", // URI template for page navigation
            'lastPage' => $galleries->lastPage(),
        ];
        return view('main.home', $data);
    }

    public function help()
    {
        return view('main.help');
    }
}
