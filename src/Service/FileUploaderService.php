<?php

namespace App\Service;

use Exception;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    private string $targetDirectory;
    private Filesystem $filesystem;

    public function __construct(string $targetDirectory, Filesystem $filesystem)
    {
        $this->targetDirectory = $targetDirectory;
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file): string
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    /**
     * @throws Exception
     */
    public function delete(string $fileName): void
    {
        $filePath = $this->getTargetDirectory() . '/' . $fileName;

        if($this->filesystem->exists($filePath)) {
            try {
                $this->filesystem->remove($filePath);
            } catch(IOExceptionInterface $exception) {
                // Gérer l'erreur, par exemple en loggant le message d'erreur ou en levant une exception
                throw new Exception("Une erreur s'est produite en tentant de supprimer le fichier");
            }
        } else {
            // Le fichier n'existe pas, on peut logger cette information ou lever une exception
            throw new FileNotFoundException("Le fichier à supprimer n'existe pas");
        }
    }

    public function checkFileExists(string $fileName): bool
    {
        return $this->filesystem->exists($this->getTargetDirectory() . '/' . $fileName);
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
