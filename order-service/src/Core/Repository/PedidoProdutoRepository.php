<?php

namespace Core\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Core\Entity\PedidoProduto;
use Doctrine\ORM\Exception\ORMException;

class PedidoProdutoRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($entityManager, $entityManager->getClassMetadata(PedidoProduto::class));
    }

    public function save(PedidoProduto $pedidoProduto): ?PedidoProduto
    {
        try {
            $this->entityManager->persist($pedidoProduto);
            $this->entityManager->flush();
            return $pedidoProduto;
        } catch (ORMException $e) {
            return null;
        }
    }
}