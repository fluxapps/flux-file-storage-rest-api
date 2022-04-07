<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\JsonBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Route;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerResponseDto;

class ExistsRoute implements Route
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


    public function getDocuRequestBodyTypes() : ?array
    {
        return null;
    }


    public function getDocuRequestQueryParams() : ?array
    {
        return null;
    }


    public function getMethod() : Method
    {
        return DefaultMethod::GET;
    }


    public function getRoute() : string
    {
        return "/exists/{path.}";
    }


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        return ServerResponseDto::new(
            JsonBodyDto::new(
                $this->file_storage_api->exists(
                    $request->getParam(
                        "path"
                    )
                )
            )
        );
    }
}
