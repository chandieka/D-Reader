<?php

namespace App\Http\Controllers;

use App\Customs\Utils;
use App\Jobs\ProcessUploadedArchive;
use App\Jobs\ProcessUploadedRarArchive;
use App\Jobs\ProcessUploadedZipArchive;
use App\Models\Gallery;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Archive;
use Exception;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;


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
        return view('main.gallery.create');
    }

    /**
     * stored the uploaded Archive and process it into a gallery
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'file' => 'required|file', // archive to be process
            'title' => 'required|string',
            'titleOriginal' => 'required|string', // nullable later
            // 'category' => '',
            // 'tags' => '',
        ]);

        $errors = [];

        // Get the uploaded file
        $archiveFile = $request->file;

        if ($archiveFile->isValid()) {
            $mimeType = $archiveFile->getMimeType();
            $fileExtension = $archiveFile->extension();
            $isZip = false;
            $isRar = false;

            // check if the file is a Zip or a Rar
            // by mime type
            switch ($mimeType) {
                case 'application/zip':
                    $isZip = true;
                    break;
                case 'application/vnd.rar':
                    $isRar = true;
                    break;
                    // case 'application/octet-stream':
                    //     $isZipOrRar = true; // might be a zip or rar can't tell
                    //     break;
                case 'application/x-zip-compressed':
                    $isZip = true;
                    break;
                case 'multipart/x-zip':
                    $isZip = true;
                    break;
            }

            // by File extension
            switch ($fileExtension) {
                case 'zip':
                    $isZip = true;
                    break;
                case 'rar':
                    $isRar = true;
                    break;
            }

            if ($isRar || $isZip) {
                // store the archived on the disk
                $archiveNewName = Str::uuid()->toString();
                $archiveStoredPath = $archiveFile->storeAs("/", $archiveNewName . "." . $fileExtension, 'archive');
                // $archiveStoredPath = "/", $archiveNewName . "." . $fileExtension, 'archive');
                $archiveFilePath = realpath(public_path('assets/archives') . "/" . $archiveStoredPath);

                // store the metadata in a model
                $archive = Archive::create([
                    'user_id' => Auth::user()->id, // should be changed to the current auth user
                    'filename' => $archiveNewName . '.' . $fileExtension, // uuid
                    'original_filename' => $archiveFile->getClientOriginalName(),
                    'size' => Utils::FileSizeConvert($archiveFile->getSize()), // formated size in (B, MB, GB and etc)
                    'archive_type' => $fileExtension, // zip or rar
                    'mime_type' => $archiveFile->getMimeType(),
                ]);

                // extract the files into a gallery
                $galleryName = Str::uuid();
                $destination = public_path('assets/galleries') . "/" . $galleryName;
                $pageNames = [];
                $isExtracted = false;

                if ($isRar) {
                    ProcessUploadedRarArchive::dispatch(Auth::user(), $archive, $request->all([
                       'title',
                       'titleOriginal',
                    ]));
                } else {
                    ProcessUploadedZipArchive::dispatch(Auth::user(), $archive, $request->all([
                        'title',
                        'titleOriginal',
                    ]));
                }

                return redirect()->route('home');
            } else {
                throw new Exception("File is not valid");
            }
        }

        return back()->withInput($requestData);
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
        // $uploader = $gallery->user()->get();
        $data['gallery'] = $gallery;
        $data['pages'] = $pages;
        // $data['uploader'] = $uploader;
        return view('main.gallery.show', $data);
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

    /**
     * Get the reader for the given gallery with all the pages related to it
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @param \App\Models\Page $page
     * @return \Illuminate\Http\Response
     */
    public function reader(Request $request, Gallery $gallery, Page $page)
    {
        $data = [];
        // $user = Auth::user();
        // $settings = $user->settings(); // fetch user UI or whatever needed in the future settings

        // assuring the Galleries is retrive starting with the lowest page to highest page
        $pages = $gallery->pages()->select(['page_number', 'filename'])->orderBy('page_number', 'asc')->get();

        $currentPageNumber = $page->page_number;
        $data['gallery'] = $gallery;
        $data['pages'] = $pages;
        $data['paginator'] = [
            'totalPages' => $pages->count(),
            'currentPage' => $currentPageNumber,
            'next' => ($currentPageNumber == $pages->count()) ? $currentPageNumber : $currentPageNumber + 1,
            'previous' => ($currentPageNumber == 1) ? $currentPageNumber : $currentPageNumber - 1,
            'resource' => "/galleries/".$gallery->id."/",
        ];

        return view('main.gallery.reader', $data);
    }

    /**
     * Get the thumbnail for a page on fly
     *
     * @param  \App\Models\Gallery  $gallery
     * @param \App\Models\Page
     */
    public function thumbnail(Gallery $gallery, Page $page)
    {
        $path = public_path('/assets/galleries/') . $gallery->dir_path . '/' . $page->filename;
        $destination = public_path('/assets/thumbnails/') . $gallery->dir_path;
        $finalWitdth = 640;

        $img = Image::make($path);
        $ratio = $finalWitdth / $img->width();
        $finalHeight = $ratio * $img->height();

        $img->resize($finalWitdth, $finalHeight);

        return $img->response();
    }
}
