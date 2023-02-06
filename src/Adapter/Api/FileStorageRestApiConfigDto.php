<?php

namespace FluxFileStorageRestApi\Adapter\Api;

use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;

class FileStorageRestApiConfigDto
{

    private function __construct(
        public readonly StorageConfigDto $storage_config
    ) {

    }


    public static function new(
        StorageConfigDto $storage_config
    ) : static {
        return new static(
            $storage_config
        );
    }


    public static function newFromEnv() : static
    {
        return static::new(
            StorageConfigDto::newFromEnv()
        );
    }
}
