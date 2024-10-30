<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114021730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subcontract (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, company_id INT NOT NULL, currency_id INT NOT NULL, description VARCHAR(255) NOT NULL, amount NUMERIC(15, 2) NOT NULL, INDEX IDX_E21F95D02576E0FD (contract_id), INDEX IDX_E21F95D0979B1AD6 (company_id), INDEX IDX_E21F95D038248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subcontract ADD CONSTRAINT FK_E21F95D02576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE subcontract ADD CONSTRAINT FK_E21F95D0979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE subcontract ADD CONSTRAINT FK_E21F95D038248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subcontract');
    }
}
