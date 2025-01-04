<?php

namespace Core\Controller;

use Core\Integration\RabbitMQConnection;
use Core\Service\PedidoService;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PedidoController
{
    private PedidoService $pedidoService;
    private RabbitMQConnection $rabbitMQConnection;

    public function __construct(PedidoService $pedidoService, RabbitMQConnection $rabbitMQConnection)
    {
        $this->pedidoService = $pedidoService;
        $this->rabbitMQConnection = $rabbitMQConnection;
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            $pedido = $this->pedidoService->create($data);

            if (is_array($pedido) && isset($pedido['error'])) {
                return $this->buildJsonResponse(
                    $response,
                    $this->buildResponseData('error', $pedido['error']),
                    400
                );
            }

            if ($pedido === null) {
                return $this->buildJsonResponse(
                    $response,
                    $this->buildResponseData('error', 'Erro ao criar Pedido'),
                    400
                );
            }

            $this->sendToQueue($pedido);

            return $this->buildJsonResponse(
                $response,
                $this->buildResponseData('success', 'Pedido criado com sucesso', $this->serialize($pedido)),
                201
            );

        } catch (Exception $e) {
            return $this->buildJsonResponse(
                $response,
                $this->buildResponseData('error', 'Erro inesperado: ' . $e->getMessage()),
                500
            );
        }
    }

    private function serialize($pedido): array
    {
        return [
            'id' => $pedido->getId(),
            'clienteId' => $pedido->getClienteId(),
            'data' => $pedido->getData()->format('Y-m-d H:i:s'),
            'valorTotal' => $pedido->getValorTotal(),
        ];
    }

    private function buildResponseData(string $status, string $message, array $data = []): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }

    private function buildJsonResponse(Response $response, array $data, int $statusCode): Response
    {
        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }

    private function sendToQueue($pedido)
    {
        $itens = [];
        foreach ($pedido->getPedidoProdutos() as $pedidoProduto) {
            $itens[] = [
                'produto' => $pedidoProduto->getProduto()->getNome(),
                'quantidade' => $pedidoProduto->getQuantidade(),
                'preco' => $pedidoProduto->getProduto()->getPreco(),
            ];
        }

        $message = [
            'codigoPedido' => $pedido->getId(),
            'codigoCliente' => $pedido->getClienteId(),
            'itens' => $itens,
        ];

        $this->rabbitMQConnection->publish('pedidos', json_encode($message));
    }
}
