<?php

namespace Core\Repository;

use Core\Entity\Pedido;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;

class PedidoRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($entityManager, $entityManager->getClassMetadata(Pedido::class));
    }

    public function save(Pedido $pedido): ?Pedido
    {
        try{
            $this->entityManager->persist($pedido);
            $this->entityManager->flush();
            return $pedido;
        } catch (ORMException $e) {
            return null;
        }
    }
}