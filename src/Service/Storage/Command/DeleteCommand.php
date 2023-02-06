<?php

namespace FluxFileStorageRestApi\Service\Storage\Command;

use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\StorageUtils;

class DeleteCommand
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


    public function delete(string $path) : void
    {
        $full_path = $this->getFullPath_(
            $path
        );

        $this->delete_(
            $full_path
        );
    }
}
