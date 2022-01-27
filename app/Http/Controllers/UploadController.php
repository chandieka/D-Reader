<?php

namespace App\Http\Controllers;

use App\Customs\UploadHandler;
use App\Customs\Utils;
use App\Jobs\ProcessUploadedRarArchive;
use App\Jobs\ProcessUploadedZipArchive;
use App\Jobs\StoreUploadedArchive;
use App\Models\Archive;
use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    // change this if you want to show more items in the manager
    // TODO: show number should be user dependend through their own settings
    protected $show = 20;

    /**
     *  Return a redirect to the archive manager
     *
     */
    public function index()
    {
        return redirect()->route('uploads.archives');
    }

    /**
     *
     *
     */
    public function archivesManager(Request $request)
    {
        $request->validate([
            'filter' => 'string|nullable'
        ]);

        $data = [];

        if ($request->input('filter') != null && $request->input('filter') != "") {
            $q = $request->input('filter');
            $archives = Archive::whereRaw("MATCH(original_filename, filename) AGAINST(? IN BOOLEAN MODE)", [$q])
                ->paginate($this->show);
            $data['archives'] = $archives;
        } else {
            $archives = Archive::where('user_id', '=', Auth()->user()->id)
                ->orderBy('id', 'desc')->with(['user', 'gallery'])
                ->paginate($this->show);
            $data['archives'] = $archives;
        }

        $data['archives_count'] = Archive::where('user_id', '=', Auth()->user()->id)->count();
        $data['galleries_count'] = Gallery::where('user_id', '=', Auth()->user()->id)->count();

        $data['paginator'] = [
            'currentPage' => $archives->currentPage(),
            'totalPages' => $archives->lastPage(),
            'uri' => route('uploads.archives') . "/?page=", // URI template for page navigation
            'lastPage' => $archives->lastPage(),
        ];

        return view('main.upload.manager.index', $data);
    }

    /**
     *
     *
     */
    public function galleriesManager(Request $request)
    {
        $request->validate([
            'filter' => 'string|nullable'
        ]);
        $request->flash();
        $data = [];

        if ($request->input('filter') != null && $request->input('filter') != "") {
            $q = $request->input('filter');
            $galleries = Gallery::whereRaw("MATCH(title_original, title) AGAINST(? IN BOOLEAN MODE)", [$q])
                ->paginate($this->show);
            $data['galleries'] = $galleries;
        } else {
            $galleries = Gallery::where('user_id', '=' , Auth()->user()->id)->orderBy('id', 'desc')->with(['user',  'archive'])->paginate($this->show);
            $data['galleries'] = $galleries;
        }

        $data['galleries_count'] = Gallery::where('user_id', '=', Auth()->user()->id)->count();
        $data['archives_count'] = Archive::where('user_id', '=', Auth()->user()->id)->count();

        $data['paginator'] = [
            'currentPage' => $galleries->currentPage(),
            'totalPages' => $galleries->lastPage(),
            'uri' => route('uploads.galleries') . "/?page=", // URI template for page navigation
            'lastPage' => $galleries->lastPage(),
        ];

        return view('main.upload.manager.index', $data);
    }

    /**
     *
     *
     */
    public function massArchiveUpload(Request $request)
    {
        $validateRequest = $request->validate([
            "files" => "required|file",
            "process" => "required|boolean", // option to check if the user want to process each archive to a gallery or not
        ]);

        $archives = $validateRequest['files'];
        $processAutomatically = $validateRequest['process'];

        foreach ($archives as $archiveFile) {
            if ($archiveFile->isValid()) {
                $fileExtension = $archiveFile->extension();
                $uploadHandler = new UploadHandler($archiveFile);

                if ($uploadHandler->checkArchiveTypeIsRar() || $uploadHandler->checkArchiveTypeIsZip()) {
                    $archiveNewName = Str::uuid()->toString();
                    // store it in the root file of archive disk driver
                    $archiveStoredPath = $archiveFile->storeAs("/", $archiveNewName . "." . $fileExtension, 'archive');

                    if ($archiveStoredPath != false) {
                        // store the metadata in the DB
                        $metadata = [
                            'user_id' => Auth::user()->id,
                            'filename' => $archiveNewName . '.' . $fileExtension, // uuid
                            'original_filename' => $archiveFile->getClientOriginalName(),
                            'size' => Utils::FileSizeConvert($archiveFile->getSize()), // formated size in (B, MB, GB and etc)
                            'archive_type' => $fileExtension, // zip or rar
                            'mime_type' => $archiveFile->getMimeType(),
                        ];

                        if ($processAutomatically){
                            StoreUploadedArchive::dispatch($metadata, $archiveFile, $processAutomatically);
                        } else {
                            StoreUploadedArchive::dispatch($metadata, $archiveFile);
                        }

                        return redirect()->route('uploads.archives');
                    } else {
                        // throw new Exception("Failed to store the Archive");
                    }
                } else {
                    // throw new Exception("File type is not valid");
                    return back()->withErrors("[Error][Extension Not Supported] - ".$archiveFile->getClientOriginalName()." file doesn't met the requirement");
                }
            }
        }
    }
}
