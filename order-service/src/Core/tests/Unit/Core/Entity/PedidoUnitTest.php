<?php

use Core\Entity\Pedido;
use Core\Entity\PedidoProduto;


test('set e get pedido', function () {
    $pedido = new Pedido();
    $pedido->setClienteId(123);
    $pedido->setValorTotal(250.00);

    expect($pedido->getClienteId())->toBe(123);
    expect($pedido->getValorTotal())->toBe(250.00);
});

test('get data', function () {
    $pedido = new Pedido();
    expect($pedido->getData())->toBeInstanceOf(\DateTime::class);
});

test('add e get pedidoProdutos', function () {
    $pedido = new Pedido();
    $pedidoProduto = new PedidoProduto();
    $pedido->addPedidoProduto($pedidoProduto);

    expect($pedido->getPedidoProdutos())->toContain($pedidoProduto);
});
