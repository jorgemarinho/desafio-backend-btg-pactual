<?php

namespace Core\Service;

use Core\Entity\Produto;
use Core\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Respect\Validation\Validator as v;

class ProdutoService
{
    private ProdutoRepository $produtoRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->produtoRepository = new ProdutoRepository($entityManager);
    }

    public function create(array $data): ?Produto
    {
        $this->validate($data);

        $produto = new Produto();
        $produto->setNome($data['nome']);
        $produto->setPreco($data['preco']);
        $produto->setQuantidade($data['quantidade']);

        return $this->produtoRepository->save($produto);
    }

    private function validate(array $data):void
    {
        $nomeValidator = v::stringType()->notEmpty();
        $precoValidator = v::floatType()->positive();
        $quantidadeValidator = v::intType()->positive();

        $nomeValidator->assert($data['nome']);
        $precoValidator->assert($data['preco']);
        $quantidadeValidator->assert($data['quantidade']);
    }
}