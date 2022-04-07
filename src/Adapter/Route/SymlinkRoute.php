<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Route;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerResponseDto;

class SymlinkRoute implements Route
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
        return [
            "to_path"
        ];
    }


    public function getMethod() : Method
    {
        return DefaultMethod::POST;
    }


    public function getRoute() : string
    {
        return "/symlink/{path.}";
    }


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        $this->file_storage_api->symlink(
            $request->getParam(
                "path"
            ),
            $request->getQueryParam(
                "to_path"
            )
        );

        return null;
    }
}
