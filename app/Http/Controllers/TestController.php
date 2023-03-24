<?php

namespace App\Http\Controllers;

use App\Customs\Utils;
use App\Jobs\ResizeGalleryPage;
use App\Models\Archive;
use App\Models\Gallery;
use DOMDocument;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Nette\Utils\Arrays;
use RarArchive;
use ZipArchive;
use PHPHtmlParser\Dom;


class TestController extends Controller
{


    public function index(Request $request)
    {
        $data = [];
        // // $data[] = Auth::user();
        // $utils = new Utils();
        // $size = $utils->folderSize('D:\1mportant\WebProject\D-Reader\storage\app\galleries');
        // dd($utils->FileSizeConvert($size));

        return view('prototype.random', $data);
    }

    public function indexTest(Request $request)
    {
        $data = [];
        // $data[] = Auth::user();

        dd($request->all());

        return view('prototype.random', $data);
    }

    public function favorite(Request $request) {
        if (Auth::check()){

            return ["status" => "OK"];
        }
        return ["status" => "BAD"];
    }

    public function fileTest(Request $request)
    {
        $file = $request->image;
        if ($file->isValid()){
            // dd($file);
            // $file->store('storage', Str::random(32).$file->extension());
            // $newName = Str::random(32) . "." . $file->extension();
            // Storage::disk('')->put($newName, $file->get());
            $name = $file->store('/', 'public');
            dd($name);
        }
    }

    public function fileStorageTest(Request $request)
    {
        // $file = Storage::disk('gallery')->getAdapter()->getPathPrefix();
        // dd($file);
        // dd($file);
        dd(uniqid());
    }
}
