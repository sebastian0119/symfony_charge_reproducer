<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001231616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD delivery_stage_id INT DEFAULT NULL, ADD delivery_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE43F930FF FOREIGN KEY (delivery_stage_id) REFERENCES contract_department (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE43F930FF ON project (delivery_stage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE43F930FF');
        $this->addSql('DROP INDEX IDX_2FB3D0EE43F930FF ON project');
        $this->addSql('ALTER TABLE project DROP delivery_stage_id, DROP delivery_date');
    }
}
