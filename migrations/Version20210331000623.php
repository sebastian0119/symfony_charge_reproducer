<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331000623 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, department_id INT NOT NULL, tax_id INT DEFAULT NULL, tax_exemption_id INT DEFAULT NULL, status_id INT NOT NULL, description VARCHAR(255) NOT NULL, amount NUMERIC(15, 2) NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, hours_architect INT DEFAULT NULL, hours_modelling INT DEFAULT NULL, INDEX IDX_E98F2859166D1F9C (project_id), INDEX IDX_E98F2859AE80F5DF (department_id), INDEX IDX_E98F2859B2A824D8 (tax_id), INDEX IDX_E98F28594700232A (tax_exemption_id), INDEX IDX_E98F28596BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
	$this->addSql('CREATE TABLE contract_department (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
	$this->addSql("
            INSERT INTO `contract_department` (`id`, `description`) VALUES
            (1, 'No clasificado'),
            (2, 'Anteproyecto'),
            (3, 'Planos constructivos'),
            (4, 'Inspección');
        ");
	$this->addSql('CREATE TABLE contract_status (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
	$this->addSql("
            INSERT INTO `contract_status` (`id`, `description`) VALUES
            (1, 'en proceso'),
            (2, 'concluido'),
            (3, 'abandonado');
        ");
	$this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(50) NOT NULL, code SMALLINT NOT NULL, code_rate SMALLINT NOT NULL, percentage NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
	$this->addSql("
            INSERT INTO `tax` (`id`, `description`, `code`, `code_rate`, `percentage`) VALUES
            (101, 'Exento (0,00%)', 1, 1, 0),
            (105, 'Transitorio (0,00%)', 1, 5, 0),
            (106, 'Transitorio (4,00%)', 1, 6, 4),
            (107, 'Transitorio (8,00%)', 1, 7, 8),
            (108, 'Tarifa general (13,00%)', 1, 8, 13);
        ");
        $this->addSql('CREATE TABLE tax_exemption (id INT AUTO_INCREMENT NOT NULL, doctype SMALLINT NOT NULL, docnumber VARCHAR(255) NOT NULL, institution VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, percentage NUMERIC(5, 2) NOT NULL, comment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859AE80F5DF FOREIGN KEY (department_id) REFERENCES contract_department (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859B2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28594700232A FOREIGN KEY (tax_exemption_id) REFERENCES tax_exemption (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28596BF700BD FOREIGN KEY (status_id) REFERENCES contract_status (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859AE80F5DF');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F28596BF700BD');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859B2A824D8');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F28594700232A');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE contract_department');
        $this->addSql('DROP TABLE contract_status');
        $this->addSql('DROP TABLE tax');
        $this->addSql('DROP TABLE tax_exemption');
    }
}
