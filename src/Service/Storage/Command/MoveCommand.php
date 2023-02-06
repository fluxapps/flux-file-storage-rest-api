<?php

namespace FluxFileStorageRestApi\Service\Storage\Command;

use Exception;
use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\StorageUtils;

class MoveCommand
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


    public function move(string $path, string $to_path) : void
    {
        $full_path = $this->getFullPath_(
            $path
        );
        if (!file_exists($full_path)) {
            throw new Exception($full_path . " does not exists");
        }

        $to_full_path = $this->getFullPath_(
            $to_path
        );
        if (file_exists($to_full_path)) {
            throw new Exception($to_full_path . " exists already");
        }

        $this->mkdirParent(
            $to_full_path
        );

        if (!rename($full_path, $to_full_path)) {
            throw new Exception("Failed to move " . $full_path . " to " . $to_full_path);
        }
    }
}
