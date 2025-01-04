<?php

namespace Core\Repository;

use Core\Entity\Produto;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;

class ProdutoRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($entityManager, $entityManager->getClassMetadata(Produto::class));
    }

    public function save(Produto $produto): ?Produto
    {
        try{
            $this->entityManager->persist($produto);
            $this->entityManager->flush();
            return $produto;
        } catch (ORMException $e) {
            return null;
        }
    }
}