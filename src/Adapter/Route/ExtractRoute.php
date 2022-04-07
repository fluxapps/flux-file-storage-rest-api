<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Route;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerResponseDto;

class ExtractRoute implements Route
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
            "delete",
            "override",
            "to_path"
        ];
    }


    public function getMethod() : Method
    {
        return DefaultMethod::POST;
    }


    public function getRoute() : string
    {
        return "/extract/{path.}";
    }


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        $this->file_storage_api->extract(
            $request->getParam(
                "path"
            ),
            $request->getQueryParam(
                "to_path"
            ),
            $request->getQueryParam(
                "override"
            ) === "true",
            $request->getQueryParam(
                "delete"
            ) === "true"
        );

        return null;
    }
}
