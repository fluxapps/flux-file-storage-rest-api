<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Route;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerResponseDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Status\DefaultStatus;

class ReadRoute implements Route
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
        return "/read/{path.}";
    }


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        $path = $this->file_storage_api->getFullPath(
            $request->getParam(
                "path"
            )
        );

        if ($path !== null) {
            return ServerResponseDto::new(
                null,
                null,
                null,
                null,
                $path
            );
        } else {
            return ServerResponseDto::new(
                null,
                DefaultStatus::_404
            );
        }
    }
}
