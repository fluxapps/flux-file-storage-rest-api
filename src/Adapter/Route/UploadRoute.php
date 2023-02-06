<?php

namespace FluxFileStorageRestApi\Adapter\Route;

use FluxFileStorageRestApi\Adapter\Api\FileStorageRestApi;
use FluxRestApi\Adapter\Body\FormDataBodyDto;
use FluxRestApi\Adapter\Body\TextBodyDto;
use FluxRestApi\Adapter\Body\Type\DefaultBodyType;
use FluxRestApi\Adapter\Method\DefaultMethod;
use FluxRestApi\Adapter\Method\Method;
use FluxRestApi\Adapter\Route\Documentation\RouteContentTypeDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteParamDocumentationDto;
use FluxRestApi\Adapter\Route\Documentation\RouteResponseDocumentationDto;
use FluxRestApi\Adapter\Route\Route;
use FluxRestApi\Adapter\Server\ServerRequestDto;
use FluxRestApi\Adapter\Server\ServerResponseDto;
use FluxRestApi\Adapter\Status\DefaultStatus;

class UploadRoute implements Route
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

        $this->file_storage_rest_api->upload(
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
