<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114014855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice_line (id INT AUTO_INCREMENT NOT NULL, invoice_id INT NOT NULL, contract_id INT DEFAULT NULL, tax_exemption_id INT DEFAULT NULL, productcode VARCHAR(20) DEFAULT NULL, description VARCHAR(255) NOT NULL, amount NUMERIC(18, 5) NOT NULL, taxcode SMALLINT DEFAULT NULL, taxcoderate SMALLINT DEFAULT NULL, taxpercentage NUMERIC(5, 2) DEFAULT NULL, taxamount NUMERIC(18, 5) DEFAULT NULL, tax_exemptionpercentage NUMERIC(5, 2) DEFAULT NULL, tax_exemptionamount NUMERIC(18, 5) DEFAULT NULL, other_charges SMALLINT DEFAULT NULL, other_identification VARCHAR(12) DEFAULT NULL, other_name VARCHAR(125) DEFAULT NULL, INDEX IDX_D3D1D6932989F1FD (invoice_id), INDEX IDX_D3D1D6932576E0FD (contract_id), INDEX IDX_D3D1D6934700232A (tax_exemption_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice_line ADD CONSTRAINT FK_D3D1D6932989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE invoice_line ADD CONSTRAINT FK_D3D1D6932576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE invoice_line ADD CONSTRAINT FK_D3D1D6934700232A FOREIGN KEY (tax_exemption_id) REFERENCES tax_exemption (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE invoice_line');
    }
}
