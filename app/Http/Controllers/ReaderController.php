<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Page;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    /**
     * Get the reader for the given gallery with all the pages related to it
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @param \App\Models\Page $page
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Gallery $gallery, Page $page)
    {
        $request->validate([
            'mode' => ["regex:/(default|list)/"],
        ]);

        if ($request->input('mode') == 'list'){
            return $this->listStyle($request, $gallery, $page);
        } else {
            return $this->pageStyle($request, $gallery, $page);
        }
    }

    private function listStyle(Request $request, Gallery $gallery, Page $page)
    {
        $data = [];

        $pages = $gallery->pages()->select(['page_number', 'filename'])->orderBy('page_number', 'asc')->get();

        $data['gallery'] = $gallery;
        $data['pages'] = $pages;

        return view('main.gallery.reader.list', $data);
    }

    private function pageStyle(Request $request, Gallery $gallery, Page $page)
    {

        $data = [];
        // assuring the Galleries is retrive starting with the lowest page to highest page
        $pages = $gallery->pages()->select(['page_number', 'filename'])->orderBy('page_number', 'asc')->get();
        $currentPageNumber = $page->page_number;

        $data['gallery'] = $gallery;
        $data['pages'] = $pages;
        $data['curentPage'] = $currentPageNumber;
        $data['paginator'] = [
            'totalPages' => $pages->count(),
            'currentPage' => $currentPageNumber,
            'next' => ($currentPageNumber == $pages->count()) ? $currentPageNumber : $currentPageNumber + 1,
            'previous' => ($currentPageNumber == 1) ? $currentPageNumber : $currentPageNumber - 1,
            'resource' => "/g/" . $gallery->id . "/",
        ];

        return view('main.gallery.reader.page', $data);
    }
}
