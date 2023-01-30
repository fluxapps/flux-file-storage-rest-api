<?php

namespace FluxFileStorageRestApi\Adapter\Server;

use FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Adapter\Route\AppendRoute;
use FluxFileStorageRestApi\Adapter\Route\CopyRoute;
use FluxFileStorageRestApi\Adapter\Route\DeleteRoute;
use FluxFileStorageRestApi\Adapter\Route\ExistsRoute;
use FluxFileStorageRestApi\Adapter\Route\ExtractRoute;
use FluxFileStorageRestApi\Adapter\Route\ListRoute;
use FluxFileStorageRestApi\Adapter\Route\MkdirRoute;
use FluxFileStorageRestApi\Adapter\Route\MoveRoute;
use FluxFileStorageRestApi\Adapter\Route\ReadRoute;
use FluxFileStorageRestApi\Adapter\Route\StoreRoute;
use FluxFileStorageRestApi\Adapter\Route\SymlinkRoute;
use FluxFileStorageRestApi\Adapter\Route\TouchRoute;
use FluxFileStorageRestApi\Adapter\Route\UploadRoute;
use FluxRestApi\Adapter\Route\Collector\RouteCollector;

class FileStorageRestApiServerRouteCollector implements RouteCollector
{

    private function __construct(
        private readonly FileStorageApi $file_storage_api
    ) {

    }


    public static function new(
        FileStorageApi $file_storage_api
    ) : static {
        return new static(
            $file_storage_api
        );
    }


    public function collectRoutes() : array
    {
        return [
            AppendRoute::new(
                $this->file_storage_api
            ),
            CopyRoute::new(
                $this->file_storage_api
            ),
            DeleteRoute::new(
                $this->file_storage_api
            ),
            ExistsRoute::new(
                $this->file_storage_api
            ),
            ExtractRoute::new(
                $this->file_storage_api
            ),
            ListRoute::new(
                $this->file_storage_api
            ),
            MkdirRoute::new(
                $this->file_storage_api
            ),
            MoveRoute::new(
                $this->file_storage_api
            ),
            ReadRoute::new(
                $this->file_storage_api
            ),
            StoreRoute::new(
                $this->file_storage_api
            ),
            SymlinkRoute::new(
                $this->file_storage_api
            ),
            TouchRoute::new(
                $this->file_storage_api
            ),
            UploadRoute::new(
                $this->file_storage_api
            )
        ];
    }
}
