<?php

namespace Core\Repository;

use Core\Entity\Cliente;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\Entity;

class ClienteRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($entityManager, $entityManager->getClassMetadata(Cliente::class));
    }

    public function save(Cliente $cliente): ?Cliente
    {
        try{
            $this->entityManager->persist($cliente);
            $this->entityManager->flush();
            return $cliente;
        } catch (ORMException $e) {
            return null;
        }
    }
}