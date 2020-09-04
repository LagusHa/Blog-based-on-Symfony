<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Created by PhpStorm.
 * User: gotohell
 * Date: 2020-07-08
 * Time: 19:12
 */

interface FileManagerServiceInterface
{
    /**
     * @param UploadedFile $file
     * @return string
     */
    public function imagePostUpload(UploadedFile $file): string;

    /**
     * @param string $filename
     * @return mixed
     */
    public function removePostImage(string $filename);
}