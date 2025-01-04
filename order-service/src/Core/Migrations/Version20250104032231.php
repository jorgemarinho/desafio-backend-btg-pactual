<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104032231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Criação da tabela de pedidos';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE clientes (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE produtos (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, preco FLOAT NOT NULL, quantidade INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pedidos (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, valor_total FLOAT NOT NULL, data DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pedido_produto (pedido_id INT NOT NULL, produto_id INT NOT NULL, quantidade INT NOT NULL, PRIMARY KEY(pedido_id, produto_id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE clientes');
        $this->addSql('DROP TABLE produtos');
        $this->addSql('DROP TABLE pedidos');
        $this->addSql('DROP TABLE pedido_produto');

    }
}
