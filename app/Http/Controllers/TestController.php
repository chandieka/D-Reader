<?php

namespace App\Http\Controllers;

use App\Customs\Utils;
use App\Models\Archive;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RarArchive;
use ZipArchive;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $data[] = Auth::user();

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

    public function galleryUpload(Request $request)
    {
        /*
            first handle the file extract
            then handle the Gallery model creation if successfull
        */
        // validate gallery metadata
        // if success then continue
        // else return to the upload page with error message
        $validated = $request->validate([
            'file' => 'required|file',
            'originalTitle' => '',
            'title' => '',
            'category' => '',
            ''
            // 'galleryTitle' =>
        ]);

        $archiveFile = $request->file;

        if ($archiveFile->isValid()){
            $mimeType = $archiveFile->getMimeType();
            $fileExtension = $archiveFile->extension();
            $isZip = false;
            $isRar = false;

            // check if the file is a Zip or a Rar file
            // check mime type
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

            // if either one of them then check the extension
            switch ($fileExtension) {
                case 'zip':
                    $isZip = true;
                    break;
                case 'rar':
                    $isRar = true;
                    break;
            }

            // Check file extension
            if ($isRar || $isZip){
                // store the archived
                $archiveNewName = Str::uuid()->toString();
                $archiveStoredPath = $archiveFile->storeAs("/", $archiveNewName.".".$fileExtension,'archive');
                $archiveFilePath = realpath(public_path('archives') . "/" . $archiveStoredPath);

                // store the metadata in a model
                $archive = Archive::create([
                    'user_id' => Auth::user()->id, // should be changed to the current auth user
                    'filename' => $archiveNewName,
                    'size' => Utils::FileSizeConvert($archiveFile->getSize()), // formated size
                    'archive_type' => $fileExtension,
                    'mime_type' => $archiveFile->getMimeType(),
                ]);

                // extract the files into a gallery
                $galleryName = Str::uuid();
                $destination = public_path('galleries') . "/" . $galleryName;
                $pageNames = [];

                if ($isRar) {
                    $rar = RarArchive::open($archiveFilePath);
                    if ($rar !== false){
                        $entries = $rar->getEntries();

                        for ($i = 0; $i < count($entries); $i++) {
                            $entry = $entries[$i];
                            // get the name for each pages
                            $pageNames[$i] = $entry->getName();
                            // extra each pages into the destination
                            $entry->extract($destination);
                        }
                        $rar->close();
                    }
                    return redirect()->back();
                }
                else{
                    $zip = new ZipArchive();
                    $res = $zip->open($archiveFilePath, ZipArchive::RDONLY);
                    if ($res === true) {

                        for ($i = 0; $i < $zip->numFiles; $i++) {
                            // get the name for each pages
                            $pageNames[$i] = $zip->getNameIndex($i);
                        }

                        // extra all pages into the destination
                        $zip->extractTo($destination);

                        $zip->close();
                    }
                }
            }
            else {
                return "it's not a Zip or a Rar file";
            }
        }
    }
}
