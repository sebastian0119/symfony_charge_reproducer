<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230917001944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project CHANGE construction_area construction_area NUMERIC(15, 2) DEFAULT NULL, CHANGE construction_cost construction_cost NUMERIC(15, 2) DEFAULT NULL, CHANGE infrastructure_cost infrastructure_cost NUMERIC(15, 2) DEFAULT NULL, CHANGE infrastructure_area infrastructure_area NUMERIC(15, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project CHANGE construction_area construction_area NUMERIC(15, 2) NOT NULL, CHANGE construction_cost construction_cost NUMERIC(15, 2) NOT NULL, CHANGE infrastructure_area infrastructure_area NUMERIC(15, 2) NOT NULL, CHANGE infrastructure_cost infrastructure_cost NUMERIC(15, 2) NOT NULL');
    }
}
