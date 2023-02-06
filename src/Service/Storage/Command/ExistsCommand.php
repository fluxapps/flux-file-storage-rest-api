<?php

namespace FluxFileStorageRestApi\Service\Storage\Command;

use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\StorageUtils;

class ExistsCommand
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


    public function exists(string $path) : bool
    {
        $full_path = $this->getFullPath_(
            $path
        );

        return file_exists($full_path);
    }
}
