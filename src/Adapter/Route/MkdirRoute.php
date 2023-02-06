<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Adapter\Api\FileStorageRestApi;
use FluxRestApi\Adapter\Method\DefaultMethod;
use FluxRestApi\Adapter\Method\Method;
use FluxRestApi\Adapter\Route\Documentation\RouteDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteParamDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteResponseDocumentationDto;
use FluxRestApi\Adapter\Route\Route;
use FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxRestApi\Adapter\Server\ServerResponseDto;

class MkdirRoute implements Route
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


    public function getDocumentation() : ?RouteDocumentationDto
    {
        return RouteDocumentationDto::new(
            $this->getRoute(),
            $this->getMethod(),
            "Create folder",
            null,
            [
                RouteParamDocumentationDto::new(
                    "path",
                    "string",
                    "Folder path"
                )
            ],
            null,
            null,
            [
                RouteResponseDocumentationDto::new()
            ]
        );
    }


    public function getMethod() : Method
    {
        return DefaultMethod::POST;
    }


    public function getRoute() : string
    {
        return "/mkdir/{path.}";
    }


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        $this->file_storage_rest_api->mkdir(
            $request->getParam(
                "path"
            )
        );

        return null;
    }
}
