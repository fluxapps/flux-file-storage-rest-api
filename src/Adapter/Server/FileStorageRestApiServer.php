<?php

namespace FluxFileStorageRestApi\Adapter\Server;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\SwooleRestApiServer;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\SwooleRestApiServerConfigDto;

class FileStorageRestApiServer
{

    private function __construct(
        private readonly SwooleRestApiServer $swoole_rest_api_server
    ) {

    }


    public static function new(
        ?FileStorageRestApiServerConfigDto $file_storage_rest_api_server_config = null
    ) : static {
        $file_storage_rest_api_server_config ??= FileStorageRestApiServerConfigDto::newFromEnv();

        return new static(
            SwooleRestApiServer::new(
                FileStorageRestApiServerRouteCollector::new(
                    FileStorageApi::new(
                        $file_storage_rest_api_server_config->file_storage_api_config
                    )
                ),
                null,
                SwooleRestApiServerConfigDto::new(
                    $file_storage_rest_api_server_config->https_cert,
                    $file_storage_rest_api_server_config->https_key,
                    $file_storage_rest_api_server_config->listen,
                    $file_storage_rest_api_server_config->port,
                    $file_storage_rest_api_server_config->max_upload_size
                )
            )
        );
    }


    public function init() : void
    {
        $this->swoole_rest_api_server->init();
    }
}
