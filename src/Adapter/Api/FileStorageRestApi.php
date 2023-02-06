<?php

namespace FluxFileStorageRestApi\Adapter\Api;

use FluxFileStorageRestApi\Adapter\File\FileDto;
use FluxFileStorageRestApi\Service\Storage\Port\StorageService;

class FileStorageRestApi
{

    private function __construct(
        private readonly FileStorageRestApiConfigDto $file_storage_rest_api_config
    ) {

    }


    public static function new(
        ?FileStorageRestApiConfigDto $file_storage_rest_api_config = null
    ) : static {
        return new static(
            $file_storage_rest_api_config ?? FileStorageRestApiConfigDto::newFromEnv()
        );
    }


    public function append(string $path, string $data) : void
    {
        $this->getStorageService()
            ->append(
                $path,
                $data
            );
    }


    public function copy(string $path, string $to_path) : void
    {
        $this->getStorageService()
            ->copy(
                $path,
                $to_path
            );
    }


    public function delete(string $path) : void
    {
        $this->getStorageService()
            ->delete(
                $path
            );
    }


    public function exists(string $path) : bool
    {
        return $this->getStorageService()
            ->exists(
                $path
            );
    }


    public function extract(string $path, string $to_path, bool $override = false, bool $delete = false) : void
    {
        $this->getStorageService()
            ->extract(
                $path,
                $to_path,
                $override,
                $delete
            );
    }


    public function getFullPath(string $path) : ?string
    {
        return $this->getStorageService()
            ->getFullPath(
                $path
            );
    }


    /**
     * @return FileDto[]|null
     */
    public function list(string $path) : ?array
    {
        return $this->getStorageService()
            ->list(
                $path
            );
    }


    public function mkdir(string $path) : void
    {
        $this->getStorageService()
            ->mkdir(
                $path
            );
    }


    public function move(string $path, string $to_path) : void
    {
        $this->getStorageService()
            ->move(
                $path,
                $to_path
            );
    }


    public function read(string $path) : ?string
    {
        return $this->getStorageService()
            ->read(
                $path
            );
    }


    public function store(string $path, string $data) : void
    {
        $this->getStorageService()
            ->store(
                $path,
                $data
            );
    }


    public function symlink(string $path, string $to_path) : void
    {
        $this->getStorageService()
            ->symlink(
                $path,
                $to_path
            );
    }


    public function touch(string $path) : void
    {
        $this->getStorageService()
            ->touch(
                $path
            );
    }


    public function upload(
        string $path,
        string $to_path,
        ?string $extract_to_path = null,
        bool $override = false,
        bool $delete = false,
        bool $extract_override = false,
        bool $extract_delete = false
    ) : void {
        $this->getStorageService()
            ->upload(
                $path,
                $to_path,
                $extract_to_path,
                $override,
                $delete,
                $extract_override,
                $extract_delete
            );
    }


    private function getStorageService() : StorageService
    {
        return StorageService::new(
            $this->file_storage_rest_api_config->storage_config
        );
    }
}
