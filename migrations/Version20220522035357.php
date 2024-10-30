<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522035357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_line ADD tax_code SMALLINT DEFAULT NULL, ADD tax_code_rate SMALLINT DEFAULT NULL, ADD tax_percentage NUMERIC(5, 2) DEFAULT NULL, ADD tax_amount NUMERIC(18, 5) DEFAULT NULL, ADD tax_exemption_percentage NUMERIC(5, 2) DEFAULT NULL, ADD tax_exemption_amount NUMERIC(18, 5) DEFAULT NULL, DROP taxcode, DROP taxcoderate, DROP taxpercentage, DROP taxamount, DROP tax_exemptionpercentage, DROP tax_exemptionamount, CHANGE productcode product_code VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_line ADD taxcode SMALLINT DEFAULT NULL, ADD taxcoderate SMALLINT DEFAULT NULL, ADD taxpercentage NUMERIC(5, 2) DEFAULT NULL, ADD taxamount NUMERIC(18, 5) DEFAULT NULL, ADD tax_exemptionpercentage NUMERIC(5, 2) DEFAULT NULL, ADD tax_exemptionamount NUMERIC(18, 5) DEFAULT NULL, DROP tax_code, DROP tax_code_rate, DROP tax_percentage, DROP tax_amount, DROP tax_exemption_percentage, DROP tax_exemption_amount, CHANGE product_code productcode VARCHAR(20) DEFAULT NULL');
    }
}
