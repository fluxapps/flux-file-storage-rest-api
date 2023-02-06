<?php

namespace FluxFileStorageRestApi\Adapter\Server;

use FluxFileStorageRestApi\Adapter\Api\FileStorageRestApi;
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
        private readonly FileStorageRestApi $file_storage_rest_api
    ) {

    }


    public static function new(
        FileStorageRestApi $file_storage_rest_api
    ) : static {
        return new static(
            $file_storage_rest_api
        );
    }


    public function collectRoutes() : array
    {
        return [
            AppendRoute::new(
                $this->file_storage_rest_api
            ),
            CopyRoute::new(
                $this->file_storage_rest_api
            ),
            DeleteRoute::new(
                $this->file_storage_rest_api
            ),
            ExistsRoute::new(
                $this->file_storage_rest_api
            ),
            ExtractRoute::new(
                $this->file_storage_rest_api
            ),
            ListRoute::new(
                $this->file_storage_rest_api
            ),
            MkdirRoute::new(
                $this->file_storage_rest_api
            ),
            MoveRoute::new(
                $this->file_storage_rest_api
            ),
            ReadRoute::new(
                $this->file_storage_rest_api
            ),
            StoreRoute::new(
                $this->file_storage_rest_api
            ),
            SymlinkRoute::new(
                $this->file_storage_rest_api
            ),
            TouchRoute::new(
                $this->file_storage_rest_api
            ),
            UploadRoute::new(
                $this->file_storage_rest_api
            )
        ];
    }
}
