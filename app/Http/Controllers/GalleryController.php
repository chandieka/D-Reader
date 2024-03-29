<?php

namespace App\Http\Controllers;

use App\Libraries\UploadHandler;
use App\Libraries\Utils;
use App\Jobs\ProcessUploadedRarArchive;
use App\Jobs\ProcessUploadedZipArchive;
use App\Models\Gallery;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Archive;
use App\Models\View;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;


class GalleryController extends Controller
{
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
    public function show(Request $request, Gallery $gallery)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($gallery->user_id != $user->id && $gallery->isHidden == 1) {
                abort(403);
            }

            View::create([
                'user_id' => $user->id,
                'gallery_id' => $gallery->id,
                'ip' => $request->ip()
            ]);
        } else {
            if ($gallery->isHidden == 1) {
                abort(403);
            }

            View::create([
                'gallery_id' => $gallery->id,
                'ip' => $request->ip()
            ]);
        }

        // $gallery->load('archive', 'favorites', 'views');
        $gallery->loadCount('views');
        $gallery->loadCount('favorites');

        $data = [];
        $data['gallery'] = $gallery;
        $data['pages'] = $gallery->pages()->get();
        $data['views'] = $gallery->views_count;
        if (Auth::check()){
            $data['isFavorite'] = $gallery->favorites()->where('user_id', Auth::user()->id)->exists();
        }

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

        $authUser = Auth::user();

        // check if the resources exist in the filesystem
        $thumbDirExist = Storage::disk('thumbnail')->exists($gallery->dir_path);
        $galleryDirExist = Storage::disk('gallery')->exists($gallery->dir_path);

        if ($galleryDirExist) {
            Storage::disk('gallery')->deleteDirectory($gallery->dir_path);
        }

        if ($thumbDirExist) {
            Storage::disk('thumbnail')->deleteDirectory($gallery->dir_path);
        }

        $parentArchive = $gallery->archive;
        $gallery->forceDelete();

        return back();
    }

    /**
     * Get the thumbnail for a page on fly
     *
     * @param  \App\Models\Gallery  $gallery
     * @param \App\Models\Page
     * @return \Illuminate\Http\Response
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


    /**
     * Set the status of a gallery
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function changeGalleryStatus(Gallery $gallery, $status)
    {
        if (Gate::denies('change-status', $gallery)) {
            abort(403);
        }

        $update = function($val, $gallery) {
            $gallery->update([
                'isHidden' => $val
            ]);
        };

        switch ($status) {
            case 0:
                $update(0, $gallery); // not visible
                break;
            case 1:
                $update(1, $gallery); // visible
                break;
        }

        return back();
    }
}
