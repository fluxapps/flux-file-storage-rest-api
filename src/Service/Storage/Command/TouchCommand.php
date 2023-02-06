<?php

namespace FluxFileStorageRestApi\Service\Storage\Command;

use Exception;
use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\StorageUtils;

class TouchCommand
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


    public function touch(string $path) : void
    {
        $full_path = $this->getFullPath_(
            $path
        );

        $this->mkdirParent(
            $full_path
        );

        if (!touch($full_path)) {
            throw new Exception("Failed to touch " . $full_path);
        }
    }
}
