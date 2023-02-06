<?php

namespace FluxFileStorageRestApi\Service\Storage\Port;

use FluxFileStorageRestApi\Adapter\File\FileDto;
use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\Command\AppendCommand;
use FluxFileStorageRestApi\Service\Storage\Command\CopyCommand;
use FluxFileStorageRestApi\Service\Storage\Command\DeleteCommand;
use FluxFileStorageRestApi\Service\Storage\Command\ExistsCommand;
use FluxFileStorageRestApi\Service\Storage\Command\ExtractCommand;
use FluxFileStorageRestApi\Service\Storage\Command\GetFullPathCommand;
use FluxFileStorageRestApi\Service\Storage\Command\ListCommand;
use FluxFileStorageRestApi\Service\Storage\Command\MkdirCommand;
use FluxFileStorageRestApi\Service\Storage\Command\MoveCommand;
use FluxFileStorageRestApi\Service\Storage\Command\ReadCommand;
use FluxFileStorageRestApi\Service\Storage\Command\StoreCommand;
use FluxFileStorageRestApi\Service\Storage\Command\SymlinkCommand;
use FluxFileStorageRestApi\Service\Storage\Command\TouchCommand;
use FluxFileStorageRestApi\Service\Storage\Command\UploadCommand;

class StorageService
{

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
        AppendCommand::new(
            $this->storage_config
        )
            ->append(
                $path,
                $data
            );
    }


    public function copy(string $path, string $to_path) : void
    {
        CopyCommand::new(
            $this->storage_config
        )
            ->copy(
                $path,
                $to_path
            );
    }


    public function delete(string $path) : void
    {
        DeleteCommand::new(
            $this->storage_config
        )
            ->delete(
                $path
            );
    }


    public function exists(string $path) : bool
    {
        return ExistsCommand::new(
            $this->storage_config
        )
            ->exists(
                $path
            );
    }


    public function extract(string $path, string $to_path, bool $override = false, bool $delete = false) : void
    {
        ExtractCommand::new(
            $this->storage_config
        )
            ->extract(
                $path,
                $to_path,
                $override,
                $delete
            );
    }


    public function getFullPath(string $path) : ?string
    {
        return GetFullPathCommand::new(
            $this->storage_config
        )
            ->getFullPath(
                $path
            );
    }


    /**
     * @return FileDto[]|null
     */
    public function list(string $path) : ?array
    {
        return ListCommand::new(
            $this->storage_config
        )
            ->list(
                $path
            );
    }


    public function mkdir(string $path) : void
    {
        MkdirCommand::new(
            $this->storage_config
        )
            ->mkdir(
                $path
            );
    }


    public function move(string $path, string $to_path) : void
    {
        MoveCommand::new(
            $this->storage_config
        )
            ->move(
                $path,
                $to_path
            );
    }


    public function read(string $path) : ?string
    {
        return ReadCommand::new(
            $this->storage_config
        )
            ->read(
                $path
            );
    }


    public function store(string $path, string $data) : void
    {
        StoreCommand::new(
            $this->storage_config
        )
            ->store(
                $path,
                $data
            );
    }


    public function symlink(string $path, string $to_path) : void
    {
        SymlinkCommand::new(
            $this->storage_config
        )
            ->symlink(
                $path,
                $to_path
            );
    }


    public function touch(string $path) : void
    {
        TouchCommand::new(
            $this->storage_config
        )
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
        UploadCommand::new(
            $this->storage_config,
            $this
        )
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
}
