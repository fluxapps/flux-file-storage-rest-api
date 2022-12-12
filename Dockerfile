FROM php:8.2-cli-alpine AS build

RUN (mkdir -p /flux-namespace-changer && cd /flux-namespace-changer && wget -O - https://github.com/fluxfw/flux-namespace-changer/releases/download/v2022-07-12-1/flux-namespace-changer-v2022-07-12-1-build.tar.gz | tar -xz --strip-components=1)

RUN (mkdir -p /build/flux-file-storage-rest-api/libs/flux-autoload-api && cd /build/flux-file-storage-rest-api/libs/flux-autoload-api && wget -O - https://github.com/fluxfw/flux-autoload-api/releases/download/v2022-12-12-1/flux-autoload-api-v2022-12-12-1-build.tar.gz | tar -xz --strip-components=1 && /flux-namespace-changer/bin/change-namespace.php . FluxAutoloadApi FluxFileStorageRestApi\\Libs\\FluxAutoloadApi)

RUN (mkdir -p /build/flux-file-storage-rest-api/libs/flux-file-storage-api && cd /build/flux-file-storage-rest-api/libs/flux-file-storage-api && wget -O - https://github.com/fluxfw/flux-file-storage-api/releases/download/v2022-12-12-1/flux-file-storage-api-v2022-12-12-1-build.tar.gz | tar -xz --strip-components=1 && /flux-namespace-changer/bin/change-namespace.php . FluxFileStorageApi FluxFileStorageRestApi\\Libs\\FluxFileStorageApi)

RUN (mkdir -p /build/flux-file-storage-rest-api/libs/flux-rest-api && cd /build/flux-file-storage-rest-api/libs/flux-rest-api && wget -O - https://github.com/fluxfw/flux-rest-api/releases/download/v2022-12-12-1/flux-rest-api-v2022-12-12-1-build.tar.gz | tar -xz --strip-components=1 && /flux-namespace-changer/bin/change-namespace.php . FluxRestApi FluxFileStorageRestApi\\Libs\\FluxRestApi)

COPY . /build/flux-file-storage-rest-api

FROM php:8.2-cli-alpine

RUN apk add --no-cache libstdc++ libzip && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS curl-dev libzip-dev openssl-dev && \
    (mkdir -p /usr/src/php/ext/swoole && cd /usr/src/php/ext/swoole && wget -O - https://pecl.php.net/get/swoole | tar -xz --strip-components=1) && \
    docker-php-ext-configure swoole --enable-openssl --enable-swoole-curl && \
    docker-php-ext-install -j$(nproc) swoole zip && \
    docker-php-source delete && \
    apk del .build-deps

USER www-data:www-data

EXPOSE 9501

ENTRYPOINT ["/flux-file-storage-rest-api/bin/server.php"]

COPY --from=build /build /

ARG COMMIT_SHA
LABEL org.opencontainers.image.revision="$COMMIT_SHA"
