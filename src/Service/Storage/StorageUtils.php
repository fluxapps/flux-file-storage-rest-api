<?php

namespace FluxFileStorageRestApi\Service\Storage;

use Exception;

trait StorageUtils
{

    private function clearCache() : void
    {
        clearstatcache();
    }


    private function delete_(string $path) : void
    {
        $this->clearCache();

        if (file_exists($path)) {
            if (is_file($path) || is_link($path)) {
                if (!unlink($path)) {
                    throw new Exception("Failed to unlink " . $path);
                }
            } else {
                exec("rm -rf " . escapeshellarg($path));
            }
        }
    }


    private function getFullPath_(string $path) : string
    {
        return $this->normalizePath(
            $this->storage_config->folder . "/" . $path
        );
    }


    private function mkdirParent(string $path) : void
    {
        $this->mkdir_(
            dirname($path)
        );
    }


    private function mkdir_(string $path) : void
    {
        if (!file_exists($path)) {
            /*if (!mkdir($path, null, true)) {
                throw new Exception("Failed to mkdir " . $path);
            }*/
            exec("mkdir -p " . escapeshellarg($path));
        }
    }


    private function normalizePath(string $path) : string
    {
        $path = trim(preg_replace("/\/+/", "/", $path), "/");

        if (str_starts_with($path, "\\") || str_starts_with($path, "..") || str_ends_with($path, "..") || str_contains($path, "/..") || str_contains($path, "../")) {
            throw new Exception("Invalid path " . $path);
        }

        if (empty($path)) {
            throw new Exception("Invalid path");
        }

        return $path;
    }
}
