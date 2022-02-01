<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use GrahamCampbell\ResultType\Result;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // fulltext search
        $fullTextSearch = Gallery::whereRaw("MATCH(title_original, title) AGAINST(? IN BOOLEAN MODE)", [$query])->get();
        // fuzzy search
        $fuzzySearch = Gallery::where('title_original', 'LIKE', "%$query%")->orWhere('title', 'LIKE', "%$query%")->get();

        // combine and remove duplicates
        $results = $fullTextSearch->concat($fuzzySearch); // append search results
        $galleries = array_unique($results->all(), SORT_STRING); // remove duplicates

        usort($galleries, function($a, $b) {
            return -($a->created_at <=> $b->created_at); // sort by date new to old
        });

        $data['galleries'] = collect($galleries);
        // $data['paginator'] = [
        //     'currentPage' => $galleries->currentPage(),
        //     'totalPages' => $galleries->currentPage(),
        //     'uri' => route('search.index') . "/?query=$query&page=", // URI template for page navigation
        //     'lastPage' => $galleries->lastPage(),
        // ];

        return view('main.search', $data);
    }
}
