ARG FLUX_AUTOLOAD_API_IMAGE=docker-registry.fluxpublisher.ch/flux-autoload/api
ARG FLUX_FILE_STORAGE_API_IMAGE=docker-registry.fluxpublisher.ch/flux-file-storage/api
ARG FLUX_NAMESPACE_CHANGER_IMAGE=docker-registry.fluxpublisher.ch/flux-namespace-changer
ARG FLUX_REST_API_IMAGE=docker-registry.fluxpublisher.ch/flux-rest/api

FROM $FLUX_AUTOLOAD_API_IMAGE:latest AS flux_autoload_api
FROM $FLUX_NAMESPACE_CHANGER_IMAGE:latest AS flux_autoload_api_build
ENV FLUX_NAMESPACE_CHANGER_FROM_NAMESPACE FluxAutoloadApi
ENV FLUX_NAMESPACE_CHANGER_TO_NAMESPACE FluxFileStorageRestApi\\Libs\\FluxAutoloadApi
COPY --from=flux_autoload_api /flux-autoload-api /code
RUN /flux-namespace-changer/bin/docker-entrypoint.php

FROM $FLUX_FILE_STORAGE_API_IMAGE:latest AS flux_file_storage_api
FROM $FLUX_NAMESPACE_CHANGER_IMAGE:latest AS flux_file_storage_api_build
ENV FLUX_NAMESPACE_CHANGER_FROM_NAMESPACE FluxFileStorageApi
ENV FLUX_NAMESPACE_CHANGER_TO_NAMESPACE FluxFileStorageRestApi\\Libs\\FluxFileStorageApi
COPY --from=flux_file_storage_api /flux-file-storage-api /code
RUN /flux-namespace-changer/bin/docker-entrypoint.php

FROM $FLUX_REST_API_IMAGE:latest AS flux_rest_api
FROM $FLUX_NAMESPACE_CHANGER_IMAGE:latest AS flux_rest_api_build
ENV FLUX_NAMESPACE_CHANGER_FROM_NAMESPACE FluxRestApi
ENV FLUX_NAMESPACE_CHANGER_TO_NAMESPACE FluxFileStorageRestApi\\Libs\\FluxRestApi
COPY --from=flux_rest_api /flux-rest-api /code
RUN /flux-namespace-changer/bin/docker-entrypoint.php

FROM alpine:latest AS build

COPY --from=flux_autoload_api_build /code /flux-file-storage-rest-api/libs/flux-autoload-api
COPY --from=flux_file_storage_api_build /code /flux-file-storage-rest-api/libs/flux-file-storage-api
COPY --from=flux_rest_api_build /code /flux-file-storage-rest-api/libs/flux-rest-api
COPY . /flux-file-storage-rest-api

FROM php:8.1-cli-alpine

LABEL org.opencontainers.image.source="https://github.com/flux-caps/flux-file-storage-rest-api"
LABEL maintainer="fluxlabs <support@fluxlabs.ch> (https://fluxlabs.ch)"

RUN apk add --no-cache libstdc++ libzip && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS curl-dev libzip-dev openssl-dev && \
    (mkdir -p /usr/src/php/ext/swoole && cd /usr/src/php/ext/swoole && wget -O - https://pecl.php.net/get/swoole | tar -xz --strip-components=1) && \
    docker-php-ext-configure swoole --enable-openssl --enable-swoole-curl --enable-swoole-json && \
    docker-php-ext-install -j$(nproc) swoole zip && \
    docker-php-source delete && \
    apk del .build-deps

USER www-data:www-data

EXPOSE 9501

ENTRYPOINT ["/flux-file-storage-rest-api/bin/server.php"]

COPY --from=build /flux-file-storage-rest-api /flux-file-storage-rest-api

ARG COMMIT_SHA
LABEL org.opencontainers.image.revision="$COMMIT_SHA"
