<?php

namespace Core\Controller;

use Core\Service\ProdutoService;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProdutoController
{
    private ProdutoService $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        try {

            $data = $request->getParsedBody();
            $Produto = $this->produtoService->create($data);

            if ($Produto) {

                $responseData = $this->buildResponseData(
                    'success',
                    'Produto criado com sucesso',
                    $this->serialize($Produto)
                );

                $statusCode = 201;
            }

            if ($Produto === null) {

                $responseData = $this->buildResponseData(
                    'error',
                    'Erro ao criar Produto',
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

    private function serialize($Produto): array
    {
        return [
            'id' => $Produto->getId(),
            'nome' => $Produto->getNome()
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
