<?php

namespace App\Http\Controllers;

use App\Customs\UploadHandler;
use App\Customs\Utils;
use App\Jobs\ProcessUploadedRarArchive;
use App\Jobs\ProcessUploadedZipArchive;
use App\Models\Archive;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchiveController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('main.archive.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'file' => 'required|file', // archive to be process
        ]);

        // Get the uploaded file
        $archiveFile = $requestData['file'];

        try {
            if ($archiveFile->isValid()) {
                $fileExtension = $archiveFile->extension();
                $uploadHandler = new UploadHandler($archiveFile);

                if ($uploadHandler->checkArchiveTypeIsRar() || $uploadHandler->checkArchiveTypeIsZip()) {
                    $archiveNewName = Str::uuid()->toString();
                    // store the archived on the disk
                    $archiveStoredPath = $archiveFile->storeAs("/", $archiveNewName . "." . $fileExtension, 'archive'); // store it in the root file of archive disk driver

                    if ($archiveStoredPath != false) {
                        // store the metadata in a model
                        Archive::create([
                            'user_id' => Auth::user()->id, // should be changed to the current auth user
                            'filename' => $archiveNewName . '.' . $fileExtension, // uuid
                            'original_filename' => $archiveFile->getClientOriginalName(),
                            'size' => Utils::FileSizeConvert($archiveFile->getSize()), // formated size in (B, MB, GB and etc)
                            'archive_type' => $fileExtension, // zip or rar
                            'mime_type' => $archiveFile->getMimeType(),
                        ]);

                        return redirect()->route('uploads.archives');
                    } else {
                        throw new Exception("Failed to store the Archive");
                    }
                } else {
                    throw new Exception("File type is not valid");
                }
            }
        } catch (Exception $ex) {
            return back()->withErrors($ex->getMessage());
        }

        return back()->withInput($requestData)->withErrors("Error");
    }

    /**
    * Store multiple archive with an option to process it right away.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function stores(Request $request)
    {
        /**
         *  TODO:
         *      - Error handling
         *      - ..
         */

        $requestData = $request->validate([
            'files.*' => 'required|file',
        ]);

        // Get the uploaded file
        $archiveFiles = $requestData['files'];
        $processNow = $request->input('process');
        $archives = [];

        foreach ($archiveFiles as $archiveFile) {
            $fileExtension = $archiveFile->extension();
            $archiveNewName = Str::uuid()->toString();
            $archiveStoredPath = $archiveFile->storeAs("/", $archiveNewName . "." . $fileExtension, 'archive');

            if ($archiveStoredPath != false) {
                // store the metadata in a model
                $archives[] = Archive::create([
                    'user_id' => Auth::user()->id, // should be changed to the current auth user
                    'filename' => $archiveNewName . '.' . $fileExtension, // uuid
                    'original_filename' => $archiveFile->getClientOriginalName(),
                    'size' => Utils::FileSizeConvert($archiveFile->getSize()), // formated size in (B, MB, GB and etc)
                    'archive_type' => $fileExtension, // zip or rar
                    'mime_type' => $archiveFile->getMimeType(),
                ]);
            } else {
                // throw new Exception("Failed to store the Archive to the disk");
            }
        }

        if ($processNow) {
            foreach ($archives as $archive) {
                if ($archive->archive_type == 'zip'){
                    ProcessUploadedZipArchive::dispatch($archive);
                } else if ($archive->archive_type == 'rar'){
                    ProcessUploadedRarArchive::dispatch($archive);
                }
            }
        }

        return redirect()->route('uploads.archives');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Archive  $archive
    * @return \Illuminate\Http\Response
    */
    public function show(Archive $archive)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Archive  $archive
    * @return \Illuminate\Http\Response
    */
    public function edit(Archive $archive)
    {
        $this->authorize('update');
        $data = [];
        $data['archive'] = $archive;

        return view('main.archive.edit', $data);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Archive  $archive
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Archive $archive)
    {
        $this->authorize('update');

        $validate = $request->validate([

        ]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Archive  $archive
    * @return \Illuminate\Http\Response
    */
    public function destroy(Archive $archive)
    {
        $this->authorize('forceDelete');

        $authUser = Auth::user();
        // Check who is the owner
        try {
            if ($authUser->id == $archive->user->id) {

                // check if a gallery is attacked to the archive
                if (!$archive->isProcess) {
                    // check if the file exist on the disk
                    $archiveExist = Storage::disk('archive')->exists($archive->filename);
                    if ($archiveExist) {
                        Storage::disk('archive')->delete($archive->filename);
                        $archive->forceDelete();
                        return back();
                    } else {
                        // delete the entries in the DB but flash a warning
                        Storage::disk('archive')->delete($archive->filename);
                        $archive->forceDelete();
                        return back()->withErrors("Delete Request Warning: Archive #$archive->id file is not present on the disk");
                    }
                } else {
                    throw new Exception("Delete Request Error: Archive #$archive->id is still attached to a gallery #" . $archive->gallery->id);
                }

            } else {
                throw new Exception("Delete Request Error: Archive #$archive->id is not owned by the user #$authUser->name");
            }
        } catch (Exception $ex) {
            return back()->withErrors($ex->getMessage(), 'error');
        }
    }

    /**
    * process the specified archive to a gallery
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Archive  $archive
    * @return \Illuminate\Http\Response
    */
    public function process(Archive $archive)
    {
        $this->authorize('process', $archive);
        if ($archive->isProcess) {
            return back()->withErrors("Archive Process Error: the archive #$archive->id had been processed", 'error');
        }

        if (Storage::disk('archive')->exists($archive->filename)) {
            if ($archive->archive_type == "zip") {
                ProcessUploadedZipArchive::dispatch($archive);
            } else {
                ProcessUploadedRarArchive::dispatch($archive);
            }
            return redirect()->route('uploads.archives');
        } else {
            return back()->withErrors("Archive Process Error: the archive #$archive->id file is not present in the disk", 'error');
        }
    }
}
