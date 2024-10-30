<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200912232056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_legalname (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, identification VARCHAR(50) NOT NULL, INDEX IDX_5952D7F3979B1AD6 (company_id), INDEX IDX_5952D7F3C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_legalname ADD CONSTRAINT FK_5952D7F3979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_legalname ADD CONSTRAINT FK_5952D7F3C54C8C93 FOREIGN KEY (type_id) REFERENCES company_legaltype (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company_legalname');
    }
}
