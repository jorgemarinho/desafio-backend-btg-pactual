<?php


namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "Core\Repository\PedidoRepository")]
#[ORM\Table(name: "pedidos")]
class Pedido
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $cliente_id;

    #[ORM\Column(type: "float")]
    private float $valor_total;

    #[ORM\Column(type: "datetime")]
    private \DateTime $data;

    #[ORM\OneToMany(targetEntity: "PedidoProduto", mappedBy: "pedido", cascade: ["persist"])]
    private $pedidoProdutos;

    public function __construct()
    {
        $this->data = new \DateTime();
    }

    // Getters e Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function getClienteId(): int
    {
        return $this->cliente_id;
    }

    public function setClienteId(int $cliente_id): void
    {
        $this->cliente_id = $cliente_id;
    }

    public function getValorTotal(): float
    {
        return $this->valor_total;
    }

    public function setValorTotal(float $valor_total): void
    {
        $this->valor_total = $valor_total;
    }

    public function getData(): \DateTime
    {
        return $this->data;
    }

    public function getPedidoProdutos()
    {
        return $this->pedidoProdutos;
    }

    public function addPedidoProduto(PedidoProduto $pedidoProduto): void
    {
        $this->pedidoProdutos[] = $pedidoProduto;
    }
}