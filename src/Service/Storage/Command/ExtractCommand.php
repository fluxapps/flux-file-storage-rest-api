<?php

namespace FluxFileStorageRestApi\Service\Storage\Command;

use Exception;
use FluxFileStorageRestApi\Adapter\Storage\StorageConfigDto;
use FluxFileStorageRestApi\Service\Storage\StorageUtils;
use ZipArchive;

class ExtractCommand
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


    public function extract(string $path, string $to_path, bool $override = false, bool $delete = false) : void
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
        if ($override) {
            $this->delete_(
                $to_full_path
            );
        } else {
            if (file_exists($to_full_path)) {
                throw new Exception($to_full_path . " exists already");
            }
        }

        $zip = null;
        try {
            $zip = new ZipArchive();

            if (($result = $zip->open($full_path)) !== true) {
                throw new Exception("Failed to open " . $full_path . " - Error code: " . $result);
            }

            if (!$zip->extractTo($to_full_path)) {
                throw new Exception("Failed to extract " . $full_path . " to " . $to_full_path);
            }
        } finally {
            $zip?->close();
        }

        if ($delete) {
            $this->delete_(
                $full_path
            );
        }
    }
}
