<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919211013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tracker_project (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, contract_id INT DEFAULT NULL, department_id INT DEFAULT NULL, regular NUMERIC(4, 1) NOT NULL, overtime NUMERIC(4, 1) NOT NULL, holiday NUMERIC(4, 1) NOT NULL, INDEX IDX_78ECAD02166D1F9C (project_id), INDEX IDX_78ECAD022576E0FD (contract_id), INDEX IDX_78ECAD02AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tracker_project ADD CONSTRAINT FK_78ECAD02166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE tracker_project ADD CONSTRAINT FK_78ECAD022576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE tracker_project ADD CONSTRAINT FK_78ECAD02AE80F5DF FOREIGN KEY (department_id) REFERENCES contract_department (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tracker_project DROP FOREIGN KEY FK_78ECAD02166D1F9C');
        $this->addSql('ALTER TABLE tracker_project DROP FOREIGN KEY FK_78ECAD022576E0FD');
        $this->addSql('ALTER TABLE tracker_project DROP FOREIGN KEY FK_78ECAD02AE80F5DF');
        $this->addSql('DROP TABLE tracker_project');
    }
}
