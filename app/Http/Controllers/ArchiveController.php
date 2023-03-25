<?php

namespace App\Http\Controllers;

use App\Libraries\UploadHandler;
use App\Libraries\Utils;
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
        // dd($request->all());

        $requestData = $request->validate([
            "files.*" => 'required|file',
        ]);

        // Get the uploaded file
        $archives = [];
        $archiveFiles = $requestData['files'];

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
                    'filesize' => $archiveFile->getSize(), // formated size in (B, MB, GB and etc)
                    'archive_type' => $fileExtension, // zip or rar
                    'mime_type' => $archiveFile->getMimeType(),
                ]);
            } else {
            }
        }

        // Send to background job for processing
        if (request()->exists("process")) {
            if (request()->process == true) {
                # code...
                foreach ($archives as $archive) {
                    if (!$archive->gallery()->exists()) {
                        if ($archive->archive_type == 'zip'){
                            ProcessUploadedZipArchive::dispatch($archive);
                        } else if ($archive->archive_type == 'rar'){
                            ProcessUploadedRarArchive::dispatch($archive);
                        }
                    }
                }
            }
        }

        return redirect()->route('uploads.archives');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Archive  $archive
    * @return \Illuminate\Http\Response
    */
    public function edit(Archive $archive)
    {
        $this->authorize('update', [$archive]);

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
        $this->authorize('update', [$archive]);

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
        $this->authorize('forceDelete', [$archive]);

        $authUser = Auth::user();
        // Check who is the owner
        try {
            if ($authUser->id == $archive->user->id) {

                // check if a gallery is attacked to the archive
                if ($archive->gallery == null) { // better indication if an archive is process
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
    * process the specified archive into a gallery
    * Different job will be dispact depending on the archive type
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
            switch ($archive->archive_type) {
                case 'zip':
                    ProcessUploadedZipArchive::dispatch($archive);
                    break;
                case 'rar':
                    ProcessUploadedRarArchive::dispatch($archive);
                    break;
                default:
                    throw new Exception("Archive Process Error: the archive #$archive->id format is not acceptable (RAR, ZIP, or etc)");
                    break;
            }
            return redirect()->route('uploads.archives');
        } else {
            return back()->withErrors("Archive Process Error: the archive #$archive->id file is not present in the disk", 'error');
        }
    }

    /**
     * give archive as a downloadable payload
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Archive  $archive
     */
    public function download(Request $request, Archive $archive)
    {
        $filePath = public_path('assets/archives') . "/" . $archive->filename;

        return response()->streamDownload(fn() => $filePath, $archive->original_filename);
    }
}
