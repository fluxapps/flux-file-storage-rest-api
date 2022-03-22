<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Body\JsonBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Status\DefaultStatus;
use FluxFileStorageRestApi\Libs\FluxRestApi\Request\RequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Response\ResponseDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Route\Route;

class ListRoute implements Route
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
        return "/list/{path.}";
    }


    public function handle(RequestDto $request) : ?ResponseDto
    {
        $files = $this->file_storage_api->list(
            $request->getParam(
                "path"
            )
        );

        if ($files !== null) {
            return ResponseDto::new(
                JsonBodyDto::new(
                    $files
                )
            );
        } else {
            return ResponseDto::new(
                null,
                DefaultStatus::_404
            );
        }
    }
}
