<?php

use Core\Entity\PedidoProduto;
use Core\Entity\Pedido;
use Core\Entity\Produto;

it('can set and get pedido', function () {
    $pedido = new Pedido();
    $pedidoProduto = new PedidoProduto();
    $pedidoProduto->setPedido($pedido);

    expect($pedidoProduto->getPedido())->toBe($pedido);
});

it('can set and get produto', function () {
    $produto = new Produto();
    $pedidoProduto = new PedidoProduto();
    $pedidoProduto->setProduto($produto);

    expect($pedidoProduto->getProduto())->toBe($produto);
});

it('can set and get quantidade', function () {
    $quantidade = 10;
    $pedidoProduto = new PedidoProduto();
    $pedidoProduto->setQuantidade($quantidade);

    expect($pedidoProduto->getQuantidade())->toBe($quantidade);
});