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

class ExtractRoute implements Route
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
            "Extract file",
            null,
            [
                RouteParamDocumentationDto::new(
                    "path",
                    "string",
                    "Source path"
                )
            ],
            [
                RouteParamDocumentationDto::new(
                    "delete",
                    "bool",
                    "Delete source after extract"
                ),
                RouteParamDocumentationDto::new(
                    "override",
                    "bool",
                    "Override destination if exists"
                ),
                RouteParamDocumentationDto::new(
                    "to_path",
                    "string",
                    "Destination path"
                )
            ],
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
        return "/extract/{path.}";
    }


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        $this->file_storage_rest_api->extract(
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
