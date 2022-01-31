<?php

namespace App\Http\Controllers;

use App\Customs\UploadHandler;
use App\Customs\Utils;
use App\Jobs\ProcessUploadedRarArchive;
use App\Jobs\ProcessUploadedZipArchive;
use App\Jobs\StoreUploadedArchive;
use App\Models\Gallery;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Archive;
use Exception;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
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
        // return Gallery::all();
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
            'titleOriginal' => 'string', // nullable later
            // 'category' => '',
            // 'tags' => '',
        ]);

        // Get the uploaded file
        $archiveFile = $request->file;
        try {

            if ($archiveFile->isValid()) {
                $mimeType = $archiveFile->getMimeType();
                $fileExtension = $archiveFile->extension();
                $uploadHandler = new UploadHandler($archiveFile);

                if ($uploadHandler->checkArchiveTypeIsRar() || $uploadHandler->checkArchiveTypeIsZip()) {
                    $archiveNewName = Str::uuid()->toString();
                    // store the archived on the disk
                    $archiveStoredPath = $archiveFile->storeAs("/", $archiveNewName . "." . $fileExtension, 'archive'); // store it in the root file of archive disk driver

                    if ($archiveStoredPath != false) {
                        // store the metadata in a model
                        $archive = Archive::create([
                            'user_id' => Auth::user()->id, // should be changed to the current auth user
                            'filename' => $archiveNewName . '.' . $fileExtension, // uuid
                            'original_filename' => $archiveFile->getClientOriginalName(),
                            'size' => Utils::FileSizeConvert($archiveFile->getSize()), // formated size in (B, MB, GB and etc)
                            'archive_type' => $fileExtension, // zip or rar
                            'mime_type' => $archiveFile->getMimeType(),
                        ]);

                        if ($uploadHandler->checkArchiveTypeIsRar()) {
                            ProcessUploadedRarArchive::dispatch($archive, $request->all([
                                'title',
                                'titleOriginal',
                            ]));
                        } else {
                            ProcessUploadedZipArchive::dispatch($archive, $request->all([
                                'title',
                                'titleOriginal',
                            ]));
                        }

                        return redirect()->route('uploads.archives');
                    } else {
                        throw new Exception("Failed to store the Archive");
                    }
                } else {
                    throw new Exception("File type is not valid");
                }
            }

            return back()->withInput([
                'title' => $request->title,
                'titleOriginal' => $request->titleOriginal
            ]);
        } catch (Exception $ex) {
            return back()->withErrors($ex->getMessage(), 'error');
        }
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
        $data['gallery'] = $gallery;
        $data['pages'] = $pages;

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
        $this->authorize('update', [$gallery]);

        $data = [];
        $data['gallery'] = $gallery;

        return view('main.gallery.edit', $data);
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
        $this->authorize('update', [$gallery]);

        $requestdata = $request->validate([
            'title' => 'required|string',
            'titleOriginal' => 'required|string'
        ]);

        // Cleaning or evaluate the string more here

        // Update gallery data fields
        $data = [
            'title' => $requestdata['title'],
            'title_original' => $requestdata['titleOriginal'],
        ];

        $success = $gallery->update($data);

        // All clear then redirect to its show page
        return redirect()->route('galleries.show', $gallery->id);
    }

    /**
    * Soft delete the specified resource from storage.
    *
    * @param  \App\Models\Gallery  $gallery
    * @return \Illuminate\Http\Response
    */
    public function destroy(Gallery $gallery)
    {
        $this->authorize('forceDelete', [$gallery]);

        // TODO: add gate authorization for resource ownership
        // TODO: check if its the owner or the admin

        $authUser = Auth::user();

        try {
            // Check who's the owner
            if ($gallery->user->id == $authUser->id) {
                // check if the dir for the resource exist
                $thumbDirExist = Storage::disk('thumbnail')->exists($gallery->dir_path);
                $galleryDirExist = Storage::disk('gallery')->exists($gallery->dir_path);

                if ($galleryDirExist && $thumbDirExist){
                    // delete the gallery directory
                    $thumbnailDeleteSuccess = Storage::disk('thumbnail')->deleteDirectory($gallery->dir_path);
                    $galleryDeleteSuccess = Storage::disk('gallery')->deleteDirectory($gallery->dir_path);

                    if ($galleryDeleteSuccess && $thumbnailDeleteSuccess) {
                        $parentArchive = $gallery->archive;
                        // delete gallery entry in DB
                        $gallery->forceDelete();
                        // Unattached gallery relation with the parent archive
                        $parentArchive->update([
                            'isProcess' => '0'
                        ]);
                        return back();
                    } else {
                        if (!$thumbnailDeleteSuccess){
                            throw new Exception("Delete Request Error: failed to delete thumbnails from the disk for gallery $gallery->id");
                        } else {
                            throw new Exception("Delete Request Error: failed to delete gallery $gallery->id from the disk");
                        }
                    }
                } else {
                    if (!$thumbDirExist) {
                        throw new Exception("Delete Request Error: the thumbnail directory for gallery $gallery->id don't exist");
                    } else {
                        throw new Exception("Delete Request Error: the directory for gallery $gallery->id don't exist");
                    }
                }
            } else {
                throw new Exception("Delete Request Error: Gallery $gallery->id is not owned by the user $authUser->name");
            }
        } catch (Exception $ex) {
            return back()->withErrors($ex->getMessage(), 'error');
        }
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
            'resource' => "/g/".$gallery->id."/",
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
