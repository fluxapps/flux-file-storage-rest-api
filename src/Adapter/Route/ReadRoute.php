<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Adapter\Api\FileStorageRestApi;
use FluxRestApi\Adapter\Body\Type\CustomBodyType;
use FluxRestApi\Adapter\Method\DefaultMethod;
use FluxRestApi\Adapter\Method\Method;
use FluxRestApi\Adapter\Route\Documentation\RouteDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteParamDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteResponseDocumentationDto;
use FluxRestApi\Adapter\Route\Route;
use FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxRestApi\Adapter\Server\ServerResponseDto;
use FluxRestApi\Adapter\Status\DefaultStatus;

class ReadRoute implements Route
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
            "Get content of file",
            null,
            [
                RouteParamDocumentationDto::new(
                    "path",
                    "string",
                    "File path"
                )
            ],
            null,
            null,
            [
                RouteResponseDocumentationDto::new(
                    CustomBodyType::factory(
                        "*"
                    ),
                    null,
                    null,
                    "File content"
                ),
                RouteResponseDocumentationDto::new(
                    null,
                    DefaultStatus::_404,
                    null,
                    "File not found"
                )
            ]
        );
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
        $path = $this->file_storage_rest_api->getFullPath(
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
