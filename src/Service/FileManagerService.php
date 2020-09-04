<?php
declare(strict_types = 1);
namespace App\Service;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Created by PhpStorm.
 * User: gotohell
 * Date: 2020-07-08
 * Time: 19:16
 */

class FileManagerService implements FileManagerServiceInterface
{
    private $postImageDirectory;

    /**
     * FileManagerService constructor.
     * @param string $postImageDirectory
     */
    public function __construct(string $postImageDirectory)
    {
        $this->postImageDirectory = $postImageDirectory;
    }

    /**
     * @return mixed
     */
    public function getPostImageDirectory()
    {
        return $this->postImageDirectory;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function imagePostUpload(UploadedFile $file): string
    {
        $fileName = uniqid() . '.' . $file->guessExtension();

        try{
            $file->move($this->postImageDirectory, $fileName);
        }   catch (FileException $exception){
            return $exception->getMessage();
        }

        return $fileName;
    }

    /**
     * @param string $fileName
     * @return mixed
     */
    public function removePostImage(string $fileName)
    {
        $fileSystem = new Filesystem();
        $fileImage = $this->getPostImageDirectory() .'/'. $fileName;
        try {
            $fileSystem->remove($fileImage);
        } catch (IOExceptionInterface $exception) {
            echo $exception->getMessage();
        }
    }
}