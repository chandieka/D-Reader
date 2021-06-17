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
            $user = Auth::user();
            $uploads = $user->galleries()->paginate(12);

            $data['galleries'] = $uploads->items();
            $data['paginator'] = $uploads;

            return view('upload', $data);
        }
        // TODO: add error message handling
        return redirect()->route('home');
    }
}
