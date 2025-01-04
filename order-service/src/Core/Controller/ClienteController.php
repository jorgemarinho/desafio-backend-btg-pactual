<?php

namespace Core\Controller;

use Core\Service\ClienteService;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ClienteController
{
    private ClienteService $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        try {

            $data = $request->getParsedBody();
            $cliente = $this->clienteService->create($data);

            if ($cliente) {

                $responseData = $this->buildResponseData(
                    'success',
                    'Cliente criado com sucesso',
                    $this->serialize($cliente)
                );

                $statusCode = 201;
            }

            if ($cliente === null) {

                $responseData = $this->buildResponseData(
                    'error',
                    'Erro ao criar cliente',
                );

                $statusCode = 400;
            }
        } catch (Exception $e) {

            $responseData = $this->buildResponseData(
                'error',
                'Erro inesperado: ' .  $e->getMessage(),
            );

            $statusCode = 500;
        }

        return $this->buildJsonResponse($response, $responseData, $statusCode);
    }

    private function serialize($cliente): array
    {
        return [
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome()
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
}
