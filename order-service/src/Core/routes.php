<?php

use Core\Controller\ClienteController;
use Core\Controller\PedidoController;
use Core\Controller\ProdutoController;
use Core\Integration\RabbitMQConnection;
use Core\Service\ClienteService;
use Core\Service\PedidoService;
use Core\Service\ProdutoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app->post('/clientes', function(Request $request, Response $response, $args) use ($container) {
    $entityManager = $container->get('entityManager');
    $clienteService = new ClienteService($entityManager);
    $controller = new ClienteController($clienteService);
    return $controller->create($request, $response, $args);
});

$app->post('/produtos', function(Request $request, Response $response, $args) use ($container) {
    $entityManager = $container->get('entityManager');
    $produtoService = new ProdutoService($entityManager);
    $controller = new ProdutoController($produtoService);
    return $controller->create($request, $response, $args);
});


$app->post('/pedidos', function(Request $request, Response $response, $args) use ($container) {
    $entityManager = $container->get('entityManager');
    $pedidoService = new PedidoService($entityManager);
    $rabbitMQConnection = new RabbitMQConnection();
    $controller = new PedidoController($pedidoService,$rabbitMQConnection);
    return $controller->create($request, $response, $args);
});


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Serviço Order BTG");
    return $response;
});