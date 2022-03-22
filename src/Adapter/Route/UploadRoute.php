<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Body\FormDataBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Body\TextBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Body\DefaultBodyType;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Libs\FluxRestBaseApi\Status\DefaultStatus;
use FluxFileStorageRestApi\Libs\FluxRestApi\Request\RequestDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Response\ResponseDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Route\Route;

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


    public function handle(RequestDto $request) : ?ResponseDto
    {
        if (!($request->getParsedBody() instanceof FormDataBodyDto)) {
            return ResponseDto::new(
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
