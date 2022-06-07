<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Libs\FluxFileStorageApi\Adapter\Api\FileStorageApi;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\FormDataBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\TextBodyDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Body\Type\DefaultBodyType;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\DefaultMethod;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Method\Method;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Documentation\RouteContentTypeDocumentationDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Documentation\RouteDocumentationDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Documentation\RouteParamDocumentationDto;
use FluxFileStorageRestApi\Libs\FluxRestApi\Adapter\Route\Documentation\RouteResponseDocumentationDto;
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


    public function getDocumentation() : ?RouteDocumentationDto
    {
        return RouteDocumentationDto::new(
            $this->getRoute(),
            $this->getMethod(),
            "Upload file",
            null,
            [
                RouteParamDocumentationDto::new(
                    "to_path",
                    "string",
                    "Destination path"
                )
            ],
            [
                RouteParamDocumentationDto::new(
                    "extract_delete",
                    "bool",
                    "Not keep uploaded file after extract"
                ),
                RouteParamDocumentationDto::new(
                    "extract_override",
                    "bool",
                    "Override extract destination if exists"
                ),
                RouteParamDocumentationDto::new(
                    "extract_to_path",
                    "string",
                    "Extract destination path"
                ),
                RouteParamDocumentationDto::new(
                    "override",
                    "bool",
                    "Override destination if exists"
                )
            ],
            [
                RouteContentTypeDocumentationDto::new(
                    DefaultBodyType::FORM_DATA_2,
                    "object",
                    "File"
                )
            ],
            [
                RouteResponseDocumentationDto::new(),
                RouteResponseDocumentationDto::new(
                    DefaultBodyType::TEXT,
                    DefaultStatus::_400,
                    null,
                    "No form data body"
                )
            ]
        );
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
        if (!($request->parsed_body instanceof FormDataBodyDto)) {
            return ServerResponseDto::new(
                TextBodyDto::new(
                    "No form data body"
                ),
                DefaultStatus::_400
            );
        }

        $this->file_storage_api->upload(
            $request->parsed_body->files["file"]["tmp_name"],
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
