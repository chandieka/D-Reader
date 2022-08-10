<?php

namespace App\Http\Controllers;

use App\Customs\Utils;
use App\Models\FavoriteGallery;
use App\Models\Gallery;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data = [];
        $data['user'] = $user;

        return view('main.user.profile', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = [];
        $data['user'] = $user;

        return view('main.user.edit', $data);
    }

    /**
     * Retrive the give user favorite list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function favoriteGalleries(User $user)
    {
        $data = [];

        $galleries = $user->favorites()->paginate(24);
        $data['galleries'] = $galleries;
        $data['user'] = $user;
        $data['paginator'] = [
            'currentPage' => $galleries->currentPage(),
            'totalPages' => $galleries->lastPage(),
            'uri' => route('users.favorite', $user->id) . "/?page=", // URI template for page navigation
            'lastPage' => $galleries->lastPage(),
        ];

        return view('main.favorites', $data);
    }

    public function favorite(Gallery $gallery)
    {
        $user = Auth::user();
        if ($gallery->favorites()->where('user_id', $user->id)->exists()) {
            return redirect()->route('galleries.show', $gallery->id);
        }

        $user->favorites()->save($gallery);

        return redirect()->route('galleries.show', $gallery->id);
    }

    public function unFavorite(Gallery $gallery)
    {
        $user = Auth::user();
        if (!$gallery->favorites()->where('user_id', $user->id)->exists()) {
            return redirect()->route('galleries.show', $gallery->id);
        }

        $user->favorites()->detach($gallery->id);

        return redirect()->route('galleries.show', $gallery->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
