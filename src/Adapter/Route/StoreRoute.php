<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\JsonBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\TextBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\Type\DefaultBodyType;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Route;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerResponseDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Status\DefaultStatus;

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


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        if (!($request->getParsedBody() instanceof JsonBodyDto)) {
            return ServerResponseDto::new(
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
