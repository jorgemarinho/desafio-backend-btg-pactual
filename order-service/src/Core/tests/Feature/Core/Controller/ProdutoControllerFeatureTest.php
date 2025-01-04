<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;
use Doctrine\ORM\Tools\SchemaTool;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

beforeEach(function () {
    $this->app = require __DIR__ . '/../../../../../../public/index.php'; // Ajuste o caminho conforme necessário

    // Configurar o banco de dados de teste
    $entityManager = $this->app->getContainer()->get('entityManager');
    $schemaTool = new SchemaTool($entityManager);
    $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
    $schemaTool->dropSchema($metadata);
    $schemaTool->createSchema($metadata);
});

it('should create a new produto', function () {
    $request = createRequest('POST', '/produtos', [
        'nome' => 'Produto Teste',
        'preco' => 100.0,
        'quantidade' => 10,
    ]);

    $response = $this->app->handle($request);

    expect($response->getStatusCode())->toBe(201);

    $data = json_decode((string) $response->getBody(), true);

    expect($data['data']['nome'])->toBe('Produto Teste');
});
