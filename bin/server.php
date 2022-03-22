#!/usr/bin/env php
<?php

require_once __DIR__ . "/../autoload.php";

use FluxFileStorageRestApi\Adapter\Server\FileStorageRestApiServer;

FileStorageRestApiServer::new()
    ->init();
