<?php

namespace App\Http\Controllers;

use DirectoryIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function index()
    {
        // $files = new DirectoryIterator('C:');
        // dd($_SERVER);
        // dd(scandir('D:'));
        // $dir = new DirectoryIterator('D:/');
        // dd($dir->current());

        return view('prototype.test.index');
    }
}
