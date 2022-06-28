<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220119100211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acnt (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pay (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, acnt_id INT DEFAULT NULL, pay_id INT DEFAULT NULL, summa DOUBLE PRECISION NOT NULL, data DATE NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_6D28840D19EB6921 (client_id), INDEX IDX_6D28840D6592071E (acnt_id), INDEX IDX_6D28840D918501AB (pay_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D6592071E FOREIGN KEY (acnt_id) REFERENCES acnt (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D918501AB FOREIGN KEY (pay_id) REFERENCES pay (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D6592071E');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D19EB6921');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D918501AB');
        $this->addSql('DROP TABLE acnt');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE pay');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
