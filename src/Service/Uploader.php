<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $extension = $file->guessExtension();
        if (!$extension) {
            $extension = 'bin';
        }
        $fileName = $this->getTargetDir().md5(uniqid()).'.'.$extension;

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}