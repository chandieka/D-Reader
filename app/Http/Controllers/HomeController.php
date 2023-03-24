<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
    * Show the application home.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index(Request $request)
    {
        $data = [];

        $galleries = Gallery::with(['pages'=> function($query) {
            $query->where('page_number', '=', 1); // get the first page along with the gallery for thumnbnail
        }])->orderBy('id', 'desc')
        ->where('isHidden', '!=', 1);

        // if log in shows the hidden galleries that the user uploaded
        if (Auth::check()) {
            $galleries = $galleries->orWhere('user_id', Auth::user()->id);
        }

        $galleries = $galleries->paginate(24);
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

    public function about()
    {
        // return view('main.about');
    }
}
