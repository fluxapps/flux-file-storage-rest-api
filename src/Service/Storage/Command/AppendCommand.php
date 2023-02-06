<?php

namespace FluxFileStorageRestApi\Service\Storage\Command;

use Exception;
use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\StorageUtils;

class AppendCommand
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


    public function append(string $path, string $data) : void
    {
        $full_path = $this->getFullPath_(
            $path
        );

        $this->mkdirParent(
            $full_path
        );

        if (!file_put_contents($full_path, $data, FILE_APPEND)) {
            throw new Exception("Failed to write " . $full_path);
        }
    }
}
