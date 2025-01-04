<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;

$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

$app->addRoutingMiddleware();

// Adicionar middleware para parsing de corpo de requisição
$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Configuração do Doctrine
$entityManager = require __DIR__ . '/../config/doctrine.php';

// Passar o EntityManager para os controladores
$container->set('entityManager', $entityManager);

require __DIR__ . '/../src/Core/routes.php';

// Verificar se o arquivo está sendo executado diretamente ou incluído
if (php_sapi_name() !== 'cli') {
    $app->run();
}

return $app;

?>