<?php

use Core\Entity\Produto;

test('set e get nome,preço e quantidade', function () {
    $produto = new Produto();
    $produto->setNome('Lápis');
    $produto->setPreco(100.00);
    $produto->setQuantidade(10);

    expect($produto->getNome())->toBe('Lápis');
    expect($produto->getPreco())->toBe(100.00);
    expect($produto->getQuantidade())->toBe(10);
});

