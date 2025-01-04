<p align="center" width="100%">
    <img width="50%" src="https://github.com/jorgemarinho/desafio-backend-btg-pactual/blob/master/images/btg-logo.jpg"> 
</p>

<h3 align="center">
  Desafio Backend do BTG Pactual
</h3>

<p align="center">
  <img alt="License: MIT" src="https://img.shields.io/badge/license-MIT-%2304D361">
  <img alt="Language: PHP" src="https://img.shields.io/badge/language-php-green">
  <img alt="Version: 1.0" src="https://img.shields.io/badge/version-1.0-yellowgreen">
</p>

[Se inscreva em nosso canal no Youtube!](https://www.youtube.com/@JorgeMarinhoDev?sub_confirmation=1)

Para um maior entendimento do código deste repositório, [assista nosso vídeo no Youtube, clique aqui.](https://www.youtube.com/watch?v=e_WgAB0Th_I)

## Desafio
Confira o enunciado completo, [clicando aqui](./problem.md).

## Microsserviços
Dividimos o desafio em dois microsserviços: Order-Service e Api.

### Order-Service

#### :rocket: Tecnologias utilizadas
* PHP 8.4
* Slim Framework
* Doctrine
* Pest PHP
* RabbitMQ
* Docker
* MySQL

### Api Rest

## Iniciando o projeto

1. Baixe o repositório:
    ```sh
    git clone https://github.com/jorgemarinho/desafio-backend-btg-pactual.git
    ```

2. Inicie o RabbitMQ:
    ```sh
    cd rabbitmq
    docker-compose up --build
    ```

3. Inicie o projeto Order Service:
    ```sh
    cd order-service
    docker-compose up --build
    ```

4. Instale as dependências com o Composer  
    1. Entre dentro da imagem do app (order-service):
        ```sh
        composer install
        ```

5. Gere as tabelas do migration:
    1. Entre dentro da imagem do app (order-service):
        ```sh
        docker-compose exec app bash
        ```
    2. Execute o comando para criar as tabelas no banco de dados:
        ```sh
        vendor/bin/doctrine-migrations migrate --configuration=/var/www/html/config/migrations.php
        ```

5. Acesse o Order Service:
    [http://localhost:8080](http://localhost:8080)

6. Acesse o RabbitMQ:
    [http://localhost:15672](http://localhost:15672)

---

# Desafio inspirado no canal Build & Run, com agradecimentos pela inspiração. 
Veja esse canal: [Build & Run](https://www.youtube.com/watch?v=e_WgAB0Th_I)

Developed by Jorge Marinho