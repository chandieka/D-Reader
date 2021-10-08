<?php

namespace App\Http\Controllers;

use App\Customs\Utils;
use App\Models\Archive;
use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    protected $show = 20;

    public function index()
    {
        return redirect()->route('uploads.archives');
    }

    public function archivesManager()
    {
        $data = [];
        $archives = Archive::where('user_id', '=', Auth()->user()->id)->orderBy('id', 'desc')->with(['user', 'gallery'])->paginate($this->show);
        $data['archives'] = $archives;

        $data['archives_count'] = $archives->total();
        $data['galleries_count'] = Gallery::where('user_id', '=', Auth()->user()->id)->count();

        $data['paginator'] = [
            'currentPage' => $archives->currentPage(),
            'totalPages' => $archives->lastPage(),
            'uri' => route('uploads.archives') . "/?page=", // URI template for page navigation
            'lastPage' => $archives->lastPage(),
        ];

        return view('main.upload.manager.index', $data);
    }

    public function galleriesManager()
    {
        $data = [];
        $galleries = Gallery::where('user_id', '=' , Auth()->user()->id)->orderBy('id', 'desc')->with(['user',  'archive'])->paginate($this->show);
        $data['galleries'] = $galleries;

        $data['galleries_count'] = $galleries->total();
        $data['archives_count'] = Archive::where('user_id', '=', Auth()->user()->id)->count();

        $data['paginator'] = [
            'currentPage' => $galleries->currentPage(),
            'totalPages' => $galleries->lastPage(),
            'uri' => route('uploads.galleries') . "/?page=", // URI template for page navigation
            'lastPage' => $galleries->lastPage(),
        ];

        return view('main.upload.manager.index', $data);
    }
}
