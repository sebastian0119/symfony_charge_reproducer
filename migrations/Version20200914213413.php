<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200914213413 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_classification (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("
            INSERT INTO `project_classification` (`id`, `description`) VALUES
            (1, 'Comercial'),
            (2, 'Industrial'),
            (3, 'Oficinas'),
            (4, 'Uso mixto'),
            (5, 'Residencia unifamiliar'),
            (6, 'Restauración'),
            (7, 'Hoteles'),
            (8, 'Residencia multifamiliar'),
            (9, 'Educativo'),
            (10, 'Institucional'),
            (11, 'Libro de marca'),
            (12, 'Informes y estudios'),
            (13, 'Remodelación');
        ");
        $this->addSql('CREATE TABLE project_scope (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("
            INSERT INTO `project_scope` (`id`, `description`) VALUES
            (1, 'core + shell'),
            (2, 'acabado'),
            (3, 'remodelación'),
            (4, 'No aplica');
        ");
        $this->addSql('CREATE TABLE project_status (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("
            INSERT INTO `project_status` (`id`, `description`) VALUES
            (1, 'en proceso'),
            (2, 'concluido');
        ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_classification');
        $this->addSql('DROP TABLE project_scope');
        $this->addSql('DROP TABLE project_status');
    }
}
