<?php

namespace FluxFileStorageRestApi\Adapter\Server;

use FluxFileStorageApi\Adapter\Api\FileStorageApiConfigDto;

class FileStorageRestApiServerConfigDto
{

    private function __construct(
        public readonly FileStorageApiConfigDto $file_storage_api_config,
        public readonly ?string $https_cert,
        public readonly ?string $https_key,
        public readonly string $listen,
        public readonly int $port,
        public readonly int $max_upload_size
    ) {

    }


    public static function new(
        FileStorageApiConfigDto $file_storage_api_config,
        ?string $https_cert = null,
        ?string $https_key = null,
        ?string $listen = null,
        ?int $port = null,
        ?int $max_upload_size = null
    ) : static {
        return new static(
            $file_storage_api_config,
            $https_cert,
            $https_key,
            $listen ?? "0.0.0.0",
            $port ?? 9501,
            $max_upload_size ?? 104857600
        );
    }


    public static function newFromEnv() : static
    {
        return static::new(
            FileStorageApiConfigDto::newFromEnv(),
            $_ENV["FLUX_FILE_STORAGE_REST_API_SERVER_HTTPS_CERT"] ?? null,
            $_ENV["FLUX_FILE_STORAGE_REST_API_SERVER_HTTPS_KEY"] ?? null,
            $_ENV["FLUX_FILE_STORAGE_REST_API_SERVER_LISTEN"] ?? null,
            $_ENV["FLUX_FILE_STORAGE_REST_API_SERVER_PORT"] ?? null,
            $_ENV["FLUX_FILE_STORAGE_REST_API_SERVER_MAX_UPLOAD_SIZE"] ?? null
        );
    }
}
