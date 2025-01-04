<?php

use Doctrine\ORM\Tools\SchemaTool;

beforeEach(function () {
    $this->app = require __DIR__ . '/../../../../../../public/index.php'; // Ajuste o caminho conforme necessário

    // Configurar o banco de dados de teste
    $entityManager = $this->app->getContainer()->get('entityManager');
    $schemaTool = new SchemaTool($entityManager);
    $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
    $schemaTool->dropSchema($metadata);
    $schemaTool->createSchema($metadata);

    // Criar produtos necessários para o teste
    $produto1 = new \Core\Entity\Produto();
    $produto1->setNome('Produto 1');
    $produto1->setPreco(50);
    $produto1->setQuantidade(100);
    $entityManager->persist($produto1);

    $produto2 = new \Core\Entity\Produto();
    $produto2->setNome('Produto 2');
    $produto2->setPreco(50);
    $produto2->setQuantidade(100);
    $entityManager->persist($produto2);

    $entityManager->flush();
});

it('should create a new pedido', function () {
    $request = createRequest('POST', '/pedidos', [
        'cliente_id' => 1,
        'produtos' => [
            [
                'id' => 1,
                'quantidade' => 2,
            ],
            [
                'id' => 2,
                'quantidade' => 1,
            ]
        ]
    ]);

    $response = $this->app->handle($request);

    expect($response->getStatusCode())->toBe(201);
    $data = json_decode((string) $response->getBody(), true);
    expect($data['data']['clienteId'])->toBe(1);
    expect($data['data']['valorTotal'])->toBe(150);
    expect($data['status'])->toBe('success');
    
});