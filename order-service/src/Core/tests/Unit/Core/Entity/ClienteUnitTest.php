<?php

use Core\Entity\Cliente;

test('set e get nome e email', function () {
    $cliente = new Cliente();
    $cliente->setNome('João Silva');

    expect($cliente->getNome())->toBe('João Silva');
});