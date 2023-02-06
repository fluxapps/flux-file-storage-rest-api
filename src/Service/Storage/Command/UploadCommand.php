<?php

namespace FluxFileStorageRestApi\Service\Storage\Command;

use Exception;
use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\Port\StorageService;
use FluxFileStorageRestApi\Service\Storage\StorageUtils;

class UploadCommand
{

    use StorageUtils;

    private function __construct(
        private readonly StorageConfigDto $storage_config,
        private readonly StorageService $storage_service
    ) {

    }


    public static function new(
        StorageConfigDto $storage_config,
        StorageService $storage_service
    ) : static {
        return new static(
            $storage_config,
            $storage_service
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
        if (!file_exists($path)) {
            throw new Exception($path . " does not exists");
        }

        $to_full_path = $this->getFullPath_(
            $to_path
        );
        if ($override) {
            $this->delete_(
                $to_full_path
            );
        } else {
            if (file_exists($to_full_path)) {
                throw new Exception($to_full_path . " exists already");
            }
        }

        $this->mkdirParent(
            $to_full_path
        );

        if (!copy($path, $to_full_path)) {
            throw new Exception("Failed to copy " . $path . " to " . $to_full_path);
        }

        if ($delete) {
            $this->delete_(
                $path
            );
        }

        if ($extract_to_path !== null) {
            $this->storage_service->extract(
                $to_path,
                $extract_to_path,
                $extract_override,
                $extract_delete
            );
        }
    }
}
