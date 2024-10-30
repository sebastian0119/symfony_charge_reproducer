<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114024341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE charge (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, project_id INT DEFAULT NULL, subcontract_id INT DEFAULT NULL, status_id INT NOT NULL, currency_id INT NOT NULL, message_date DATE DEFAULT NULL, message_number INT DEFAULT NULL, message_code VARCHAR(50) DEFAULT NULL, transmit SMALLINT NOT NULL, company_legaltype SMALLINT NOT NULL, company_identification VARCHAR(25) NOT NULL, company_activity VARCHAR(8) NOT NULL, date DATE NOT NULL, reply SMALLINT NOT NULL, number VARCHAR(10) NOT NULL, code VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, factor SMALLINT NOT NULL, related VARCHAR(50) DEFAULT NULL, tax_amount NUMERIC(18, 5) DEFAULT NULL, tax_condition SMALLINT DEFAULT NULL, tax_credit NUMERIC(18, 5) DEFAULT NULL, tax_expense NUMERIC(18, 5) DEFAULT NULL, amount NUMERIC(18, 5) NOT NULL, comment VARCHAR(80) DEFAULT NULL, treasury VARCHAR(255) DEFAULT NULL, registered_by VARCHAR(50) NOT NULL, registered_on DATETIME NOT NULL, INDEX IDX_556BA434979B1AD6 (company_id), INDEX IDX_556BA434166D1F9C (project_id), INDEX IDX_556BA4346AF68348 (subcontract_id), INDEX IDX_556BA4346BF700BD (status_id), INDEX IDX_556BA43438248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge_status (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("
                INSERT INTO `charge_status` (`id`, `description`) VALUES
                (1, 'pending'),
                (2, 'paid'),
                (3, 'void'),
                (4, 'rejected'),
                (10, 'error');
            ");
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA434979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA434166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA4346AF68348 FOREIGN KEY (subcontract_id) REFERENCES subcontract (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA4346BF700BD FOREIGN KEY (status_id) REFERENCES charge_status (id)');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA43438248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA4346BF700BD');
        $this->addSql('DROP TABLE charge');
        $this->addSql('DROP TABLE charge_status');
    }
}
