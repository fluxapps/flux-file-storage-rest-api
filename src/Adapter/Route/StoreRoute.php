<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Body\JsonBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Body\TextBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Body\DefaultBodyType;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Status\DefaultStatus;
use FluxFileStorageRestApi\Libs\FluxRestApi\Request\RequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Response\ResponseDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Route\Route;

class StoreRoute implements Route
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
        return [
            DefaultBodyType::JSON
        ];
    }


    public function getDocuRequestQueryParams() : ?array
    {
        return null;
    }


    public function getMethod() : Method
    {
        return DefaultMethod::POST;
    }


    public function getRoute() : string
    {
        return "/store/{path.}";
    }


    public function handle(RequestDto $request) : ?ResponseDto
    {
        if (!($request->getParsedBody() instanceof JsonBodyDto)) {
            return ResponseDto::new(
                TextBodyDto::new(
                    "No json body"
                ),
                DefaultStatus::_400
            );
        }

        $this->file_storage_api->store(
            $request->getParam(
                "path"
            ),
            $request->getParsedBody()->getData()->data
        );

        return null;
    }
}
