<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920031341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract CHANGE tax_id tax_id INT NOT NULL');
        $this->addSql('ALTER TABLE tracker_project ADD tracker_id INT NOT NULL');
        $this->addSql('ALTER TABLE tracker_project ADD CONSTRAINT FK_78ECAD02FB5230B FOREIGN KEY (tracker_id) REFERENCES tracker (id)');
        $this->addSql('CREATE INDEX IDX_78ECAD02FB5230B ON tracker_project (tracker_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract CHANGE tax_id tax_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tracker_project DROP FOREIGN KEY FK_78ECAD02FB5230B');
        $this->addSql('DROP INDEX IDX_78ECAD02FB5230B ON tracker_project');
        $this->addSql('ALTER TABLE tracker_project DROP tracker_id');
    }
}
