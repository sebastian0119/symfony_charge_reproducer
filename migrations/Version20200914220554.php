<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200914220554 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, companylegal_id INT NOT NULL, classification_id INT NOT NULL, scope_id INT NOT NULL, country_id INT NOT NULL, province_id INT DEFAULT NULL, canton_id INT DEFAULT NULL, district_id INT DEFAULT NULL, status_id INT NOT NULL, code VARCHAR(15) DEFAULT NULL, name VARCHAR(255) NOT NULL, cadastralmap VARCHAR(255) DEFAULT NULL, propertyregister VARCHAR(255) DEFAULT NULL, construction_area NUMERIC(15, 2) NOT NULL, construction_cost NUMERIC(15, 2) NOT NULL, infrastructure_cost NUMERIC(15, 2) NOT NULL, infrastructure_area NUMERIC(15, 2) NOT NULL, public_work TINYINT(1) NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, INDEX IDX_2FB3D0EE979B1AD6 (company_id), INDEX IDX_2FB3D0EE36A1C7F3 (companylegal_id), INDEX IDX_2FB3D0EE2A86559F (classification_id), INDEX IDX_2FB3D0EE682B5931 (scope_id), INDEX IDX_2FB3D0EEF92F3E70 (country_id), INDEX IDX_2FB3D0EEE946114A (province_id), INDEX IDX_2FB3D0EE8D070D0B (canton_id), INDEX IDX_2FB3D0EEB08FA272 (district_id), INDEX IDX_2FB3D0EE6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE36A1C7F3 FOREIGN KEY (companylegal_id) REFERENCES company_legalname (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE2A86559F FOREIGN KEY (classification_id) REFERENCES project_classification (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE682B5931 FOREIGN KEY (scope_id) REFERENCES project_scope (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEE946114A FOREIGN KEY (province_id) REFERENCES cr_province (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE8D070D0B FOREIGN KEY (canton_id) REFERENCES cr_canton (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB08FA272 FOREIGN KEY (district_id) REFERENCES cr_district (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6BF700BD FOREIGN KEY (status_id) REFERENCES project_status (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project');
    }
}
