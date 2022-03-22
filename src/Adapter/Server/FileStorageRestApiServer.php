<?php

namespace FluxFileStorageRestApi\Adapter\Server;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Collector\FolderRouteCollector;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Handler\SwooleHandler;
use Swoole\Http\Server;

class FileStorageRestApiServer
{

    private function __construct(
        private readonly FileStorageRestApiServerConfigDto $file_storage_rest_api_server_config,
        private readonly SwooleHandler $swoole_handler
    ) {

    }


    public static function new(
        ?FileStorageRestApiServerConfigDto $file_storage_rest_api_server_config = null
    ) : static {
        $file_storage_rest_api_server_config ??= FileStorageRestApiServerConfigDto::newFromEnv();

        return new static(
            $file_storage_rest_api_server_config,
            SwooleHandler::new(
                FolderRouteCollector::new(
                    __DIR__ . "/../Route",
                    [
                        FileStorageApi::new(
                            $file_storage_rest_api_server_config->file_storage_api_config
                        )
                    ]
                )
            )
        );
    }


    public function init() : void
    {
        $options = [
            "package_max_length" => $this->file_storage_rest_api_server_config->max_upload_size
        ];
        $sock_type = SWOOLE_TCP;

        if ($this->file_storage_rest_api_server_config->https_cert !== null) {
            $options += [
                "ssl_cert_file" => $this->file_storage_rest_api_server_config->https_cert,
                "ssl_key_file"  => $this->file_storage_rest_api_server_config->https_key
            ];
            $sock_type += SWOOLE_SSL;
        }

        $server = new Server($this->file_storage_rest_api_server_config->listen, $this->file_storage_rest_api_server_config->port, SWOOLE_PROCESS, $sock_type);

        $server->set($options);

        $server->on("request", [$this->swoole_handler, "handle"]);

        $server->start();
    }
}
