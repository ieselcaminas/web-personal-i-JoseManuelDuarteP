<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030090251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aeronave (id INT AUTO_INCREMENT NOT NULL, propietario_id INT NOT NULL, modelo VARCHAR(255) NOT NULL, fecha_construccion DATE NOT NULL, apodo VARCHAR(255) DEFAULT NULL, INDEX IDX_2B343AD853C8D32C (propietario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE propietario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, telefono VARCHAR(255) DEFAULT NULL, edad INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE aeronave ADD CONSTRAINT FK_2B343AD853C8D32C FOREIGN KEY (propietario_id) REFERENCES propietario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aeronave DROP FOREIGN KEY FK_2B343AD853C8D32C');
        $this->addSql('DROP TABLE aeronave');
        $this->addSql('DROP TABLE propietario');
    }
}
