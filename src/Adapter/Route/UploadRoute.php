<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\FormDataBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\TextBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\Type\DefaultBodyType;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Route;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Server\ServerResponseDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Status\DefaultStatus;

class UploadRoute implements Route
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
            DefaultBodyType::FORM_DATA
        ];
    }


    public function getDocuRequestQueryParams() : ?array
    {
        return [
            "extract_override",
            "extract_delete",
            "extract_to_path",
            "override"
        ];
    }


    public function getMethod() : Method
    {
        return DefaultMethod::POST;
    }


    public function getRoute() : string
    {
        return "/upload/{to_path.}";
    }


    public function handle(ServerRequestDto $request) : ?ServerResponseDto
    {
        if (!($request->getParsedBody() instanceof FormDataBodyDto)) {
            return ServerResponseDto::new(
                TextBodyDto::new(
                    "No form data body"
                ),
                DefaultStatus::_400
            );
        }

        $this->file_storage_api->upload(
            $request->getParsedBody()->getFiles()["file"]["tmp_name"],
            $request->getParam(
                "to_path"
            ),
            $request->getQueryParam(
                "extract_to_path"
            ),
            $request->getQueryParam(
                "override"
            ) === "true",
            false,
            $request->getQueryParam(
                "extract_override"
            ) === "true",
            $request->getQueryParam(
                "extract_delete"
            ) === "true"
        );

        return null;
    }
}
