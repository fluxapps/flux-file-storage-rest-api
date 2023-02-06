<?php

namespace FluxFileStorageRestApi\Adapter\Storage;

class StorageConfigDto
{

    private function __construct(
        public readonly string $folder
    ) {

    }


    public static function new(
        ?string $folder = null
    ) : static {
        return new static(
            $folder ?? "/file-storage"
        );
    }


    public static function newFromEnv() : static
    {
        return static::new(
            $_ENV["FLUX_FILE_STORAGE_REST_API_STORAGE_FOLDER"] ?? null
        );
    }
}
