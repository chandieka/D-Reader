<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'query' => "required|string"
        ]);
        $request->flash();

        $query = $request->input('query');

        $data = [];

        $data['query'] = $query;

        $galleries = Gallery::whereRaw("MATCH(title_original, title) AGAINST(? IN BOOLEAN MODE)", [$query])->paginate(24);

        $data['galleries'] = $galleries;
        $data['paginator'] = [
            'currentPage' => $galleries->currentPage(),
            'totalPages' => $galleries->currentPage(),
            'uri' => route('search.index') . "/?query=$query&page=", // URI template for page navigation
            'lastPage' => $galleries->lastPage(),
        ];

        return view('main.search', $data);
    }
}
