<?php

namespace FluxFileStorageRestApi\Adapter\Server;

use FluxFileStorageRestApi\Adapter\Api\FileStorageRestApi;
use FluxRestApi\Adapter\Api\RestApi;
use FluxRestApi\Adapter\Route\Collector\RouteCollector;
use FluxRestApi\Adapter\Server\SwooleServerConfigDto;

class FileStorageRestApiServer
{

    private function __construct(
        private readonly RestApi $rest_api,
        private readonly RouteCollector $route_collector,
        private readonly SwooleServerConfigDto $swoole_server_config
    ) {

    }


    public static function new(
        ?FileStorageRestApiServerConfigDto $file_storage_rest_api_server_config = null
    ) : static {
        $file_storage_rest_api_server_config ??= FileStorageRestApiServerConfigDto::newFromEnv();

        return new static(
            RestApi::new(),
            FileStorageRestApiServerRouteCollector::new(
                FileStorageRestApi::new(
                    $file_storage_rest_api_server_config->file_storage_rest_api_config
                )
            ),
            SwooleServerConfigDto::new(
                $file_storage_rest_api_server_config->https_cert,
                $file_storage_rest_api_server_config->https_key,
                $file_storage_rest_api_server_config->listen,
                $file_storage_rest_api_server_config->port,
                $file_storage_rest_api_server_config->max_upload_size
            )
        );
    }


    public function init() : void
    {
        $this->rest_api->initSwooleServer(
            $this->route_collector,
            null,
            $this->swoole_server_config
        );
    }
}
