<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114011356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, companylegal_id INT NOT NULL, project_id INT NOT NULL, company_legaltype_id INT NOT NULL, currency_id INT NOT NULL, status_id INT NOT NULL, doctype SMALLINT NOT NULL, number INT NOT NULL, transmit SMALLINT NOT NULL, code VARCHAR(50) DEFAULT NULL, identification VARCHAR(25) NOT NULL, sales_condition SMALLINT NOT NULL, payment_method SMALLINT NOT NULL, date DATE NOT NULL, exchangerate NUMERIC(10, 4) NOT NULL, comment VARCHAR(255) DEFAULT NULL, generated_by VARCHAR(50) NOT NULL, generated_on DATETIME NOT NULL, INDEX IDX_9065174436A1C7F3 (companylegal_id), INDEX IDX_90651744166D1F9C (project_id), INDEX IDX_906517442E847BA5 (company_legaltype_id), INDEX IDX_9065174438248176 (currency_id), INDEX IDX_906517446BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_status (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("
                INSERT INTO `invoice_status` (`id`, `description`) VALUES
                (1, 'pending'),
                (2, 'paid'),
                (4, 'uncollectible'),
                (5, 'void'),
                (6, 'receipt'),
                (10, 'error');
            ");
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174436A1C7F3 FOREIGN KEY (companylegal_id) REFERENCES company_legalname (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517442E847BA5 FOREIGN KEY (company_legaltype_id) REFERENCES company_legaltype (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174438248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517446BF700BD FOREIGN KEY (status_id) REFERENCES invoice_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517446BF700BD');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE invoice_status');
    }
}
