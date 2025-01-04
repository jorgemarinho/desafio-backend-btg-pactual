<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "Core\Repository\PedidoProdutoRepository")]
#[ORM\Table(name: "pedido_produto")]
class PedidoProduto
{

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: "Pedido", inversedBy: "pedidoProdutos")]
    #[ORM\JoinColumn(name: "pedido_id", referencedColumnName: "id")]
    private Pedido $pedido;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: "Produto")]
    #[ORM\JoinColumn(name: "produto_id", referencedColumnName: "id")]
    private Produto $produto;

    #[ORM\Column(type: "integer")]
    private int $quantidade;

     // Getters and Setters
     public function getPedido(): Pedido
     {
         return $this->pedido;
     }
 
     public function setPedido(Pedido $pedido): void
     {
         $this->pedido = $pedido;
     }
 
     public function getProduto(): Produto
     {
         return $this->produto;
     }
 
     public function setProduto(Produto $produto): void
     {
         $this->produto = $produto;
     }
 
     public function getQuantidade(): int
     {
         return $this->quantidade;
     }
 
     public function setQuantidade(int $quantidade): void
     {
         $this->quantidade = $quantidade;
     }
 
}