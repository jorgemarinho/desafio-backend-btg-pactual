<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;

function createRequest(string $method, string $path, array $body = []): Request
{
    $uri = new \Slim\Psr7\Uri('', '', 80, $path);
    $serverParams = [];
    $request = (new ServerRequestFactory())->createServerRequest($method, $uri, $serverParams)
        ->withParsedBody($body);

    return $request;
}