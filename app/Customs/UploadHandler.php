<?php

namespace App\Customs;

use Illuminate\Http\UploadedFile;

class UploadHandler
{
    private $file;

    public function __construct(UploadedFile $uploadedFile) {
        $this->file = $uploadedFile;
    }

    public function checkArchiveTypeIsZip()
    {
        $mimeType = $this->file->getMimeType();
        $fileExtension = $this->file->extension();
        // by mime type
        switch ($mimeType) {
            case 'application/zip':
                return true;
                break;
            case 'application/x-zip-compressed':
                return true;
                break;
            case 'multipart/x-zip':
                return true;
                break;
        }
        // by file extension
        if ($fileExtension == 'zip') {
            return true;
        }

        return false;
    }

    public function checkArchiveTypeIsRar()
    {
        $mimeType = $this->file->getMimeType();
        $fileExtension = $this->file->extension();

        if ($mimeType == 'application/vnd.rar' || $fileExtension == 'rar') {
            return true;
        }

        return false;
    }

    public function mimeType(){
        return $this->file->getMimeType();
    }

    public function fileExtension() {
        return $this->file->extension();
    }
}


