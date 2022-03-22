<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Request\RequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Response\ResponseDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Route\Route;

class MoveRoute implements Route
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
        return "/move/{path.}";
    }


    public function handle(RequestDto $request) : ?ResponseDto
    {
        $this->file_storage_api->move(
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
