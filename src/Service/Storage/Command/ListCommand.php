<?php

namespace FluxFileStorageRestApi\Service\Storage\Command;

use DirectoryIterator;
use FluxFileStorageRestApi\Adapter\File\FileDto;
use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\StorageUtils;

class ListCommand
{

    use StorageUtils;

    private function __construct(
        private readonly StorageConfigDto $storage_config
    ) {

    }


    public static function new(
        StorageConfigDto $storage_config
    ) : static {
        return new static(
            $storage_config
        );
    }


    /**
     * @return FileDto[]|null
     */
    public function list(string $path) : ?array
    {
        $full_path = $this->getFullPath_(
            $path
        );
        if (!file_exists($full_path)) {
            return null;
        }

        $files = [];
        foreach (new DirectoryIterator($full_path) as $file) {
            if ($file->isDot()) {
                continue;
            }

            $files[] = FileDto::new(
                $file->getBasename()
            );
        }

        usort($files, fn(FileDto $file1, FileDto $file2) : int => strnatcasecmp($file1->name, $file2->name));

        return $files;
    }
}
