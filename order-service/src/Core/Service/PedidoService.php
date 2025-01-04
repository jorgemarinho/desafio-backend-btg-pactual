<?php

namespace Core\Service;

use Core\Entity\Pedido;
use Core\Entity\PedidoProduto;
use Core\Entity\Produto;
use Core\Repository\PedidoProdutoRepository;
use Core\Repository\PedidoRepository;
use Core\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Respect\Validation\Validator as v;

class PedidoService
{
    private PedidoRepository $pedidoRepository;
    private ProdutoRepository $produtoRepository;
    private PedidoProdutoRepository $pedidoProdutoRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->pedidoRepository = new PedidoRepository($entityManager);
        $this->produtoRepository = new ProdutoRepository($entityManager);
        $this->pedidoProdutoRepository = new PedidoProdutoRepository($entityManager);
        $this->entityManager = $entityManager;
    }

    public function create(array $data)
    {
        if (!isset($data['cliente_id']) || !isset($data['produtos'])) {
            return ['error' => 'Dados inválidos'];
        }

        $this->entityManager->beginTransaction();

        try {

            $pedido = $this->createPedido($data['cliente_id']);
            $valorTotal = $this->processarProdutos($pedido, $data['produtos']);
            $pedido->setValorTotal($valorTotal);

            $this->pedidoRepository->save($pedido);
            $this->entityManager->commit();

            return $pedido;
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            return ['error' => $e->getMessage()];
        }
    }

    private function createPedido(int $clienteId): Pedido
    {
        $pedido = new Pedido();
        $pedido->setClienteId($clienteId);
        $pedido->setValorTotal(0);
        $this->pedidoRepository->save($pedido);
        return $pedido;
    }

    private function processarProdutos(Pedido $pedido, array $produtosData): float
    {
        $valorTotal = 0;

        foreach ($produtosData as $produtoData) {
            $produto = $this->produtoRepository->find($produtoData['id']);

            if (!$produto) {
                throw new \Exception('Produto não encontrado');
            }

            if ($produto->getQuantidade() < $produtoData['quantidade']) {
                throw new \Exception("O Produto ({$produto->getNome()}) não tem essa quantidade em estoque");
            }

            $produto->setQuantidade($produto->getQuantidade() - $produtoData['quantidade']);
            $this->produtoRepository->save($produto);

            $valorTotal += $produto->getPreco() * $produtoData['quantidade'];

            $pedidoProduto = new PedidoProduto();
            $pedidoProduto->setPedido($pedido);
            $pedidoProduto->setProduto($produto);
            $pedidoProduto->setQuantidade($produtoData['quantidade']);

            $pedido->addPedidoProduto($pedidoProduto);

            $this->pedidoProdutoRepository->save($pedidoProduto);
        }

        return $valorTotal;
    }
}
