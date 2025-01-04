<?php

namespace Core\Service;

use Core\Entity\Cliente;
use Core\Repository\ClienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Respect\Validation\Validator as v;

class ClienteService
{
    private ClienteRepository $clienteRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->clienteRepository = new ClienteRepository($entityManager);
    }

    public function create(array $data): ?Cliente
    {
        $this->validate($data);

        $cliente = new Cliente();
        $cliente->setNome($data['nome']);
        return $this->clienteRepository->save($cliente);
    }

    private function validate(array $data):void
    {
        $nomeValidator = v::stringType()->notEmpty()->setName('Nome');
        $nomeValidator->assert($data['nome']);
    }
}