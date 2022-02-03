<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use GrahamCampbell\ResultType\Result;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /**
     * This function handle the "basic" search request on all galleries
     * it is used directly as a callback by the route statement
     *
     * @param $request
     */
    public function index(Request $request)
    {
        $request->validate([
            'query' => "required|string",
            'page' => "integer",
        ]);

        $request->flash(); // flash old variable

        $query = $request->input('query');

        $data = []; // define a wrapper variable for all data to be pass onto the view

        $data['query'] = $query; // pass the query string for show in the view

        // Note: idk if this good or not but it work... and its hella inefficient
        // this group of code is essentially repeating where statement for each "word" in the query
        $querys = Str::of($query)->explode(' ');
        $queryBuilder = Gallery::where('title', 'LIKE', "%$querys[0]%");
        $queryBuilder->orWhere('title_original', 'LIKE', "%$querys[0]%");
        for ($i=1; $i < $querys->count(); $i++) {
            $queryBuilder->orWhere('title', 'LIKE', "%$querys[$i]%");
            $queryBuilder->orWhere('title_original', 'LIKE', "%$querys[$i]%");
        }
        // do a fulltext on the string againts predefined index
        // not safe, the $query variable need to sanitize first beforehand
        $queryBuilder->orWhereRaw("MATCH(title_original, title) AGAINST(? IN BOOLEAN MODE)", [$query]);
        $queryResults = $queryBuilder->get();

        $galleries = array_unique($queryResults->all(), SORT_STRING); // remove duplicates

        // sort by date new to old
        usort($galleries, function($a, $b) {
            return -($a->created_at <=> $b->created_at);
        });

        // turn back $galleries array back into collection
        $galleries = collect($galleries);

        $galleries = new LengthAwarePaginator($galleries, $galleries->count(), 24, $request->input('page'));

        $data['galleries'] = $galleries; // will be use on the view to iterate a card with the info of the galleris
        $data['paginator'] = [
            'currentPage' => $galleries->currentPage(),
            'totalPages' => $galleries->currentPage(),
            'uri' => route('search.index') . "/?query=$query&page=", // URI template for page navigation
            'lastPage' => $galleries->lastPage(),
        ];

        return view('main.search', $data);
    }
}
