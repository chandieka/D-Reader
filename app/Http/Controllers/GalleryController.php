<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        $data = [];
        $pages = $gallery->pages()->get();
        $uploader = $gallery->user()->get();
        $data['gallery'] = $gallery;
        $data['pages'] = $pages;
        $data['uploader'] = $uploader;

        return view('gallery', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }

    public function reader(Request $request, Gallery $gallery, $currentPage)
    {
        # code...
        $data = [];
        // $user = Auth::user();
        // $settings = $user->settings(); // fetch user UI or whatever needed in the future settings

        $pages = $gallery->pages()->orderBy('page_number', 'asc')->get(); // assuring the array is retrive starting with the lowest page to highest page

        $data['reader'] = [
            'paginator' => [
                'totalPage' => $pages->count(),
                'currentPage' => $currentPage,
            ],
            'pages' => $pages,
            // settings variable
        ];

        return view('reader', $data);
    }
}
