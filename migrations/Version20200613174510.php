<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613174510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cr_district (id INT AUTO_INCREMENT NOT NULL, canton_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_A90511398D070D0B (canton_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cr_canton (id INT AUTO_INCREMENT NOT NULL, province_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_5253FEFEE946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cr_province (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cr_district ADD CONSTRAINT FK_A90511398D070D0B FOREIGN KEY (canton_id) REFERENCES cr_canton (id)');
        $this->addSql('ALTER TABLE cr_canton ADD CONSTRAINT FK_5253FEFEE946114A FOREIGN KEY (province_id) REFERENCES cr_province (id)');
        $this->addSql('ALTER TABLE company ADD province_id INT DEFAULT NULL, ADD canton_id INT DEFAULT NULL, ADD district_id INT DEFAULT NULL, CHANGE alternate alternate VARCHAR(255) DEFAULT NULL, CHANGE phone01 phone01 VARCHAR(255) DEFAULT NULL, CHANGE phone02 phone02 VARCHAR(255) DEFAULT NULL, CHANGE fax fax VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FE946114A FOREIGN KEY (province_id) REFERENCES cr_province (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F8D070D0B FOREIGN KEY (canton_id) REFERENCES cr_canton (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FB08FA272 FOREIGN KEY (district_id) REFERENCES cr_district (id)');
        $this->addSql('CREATE INDEX IDX_4FBF094FE946114A ON company (province_id)');
        $this->addSql('CREATE INDEX IDX_4FBF094F8D070D0B ON company (canton_id)');
        $this->addSql('CREATE INDEX IDX_4FBF094FB08FA272 ON company (district_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FB08FA272');
        $this->addSql('ALTER TABLE cr_district DROP FOREIGN KEY FK_A90511398D070D0B');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F8D070D0B');
        $this->addSql('ALTER TABLE cr_canton DROP FOREIGN KEY FK_5253FEFEE946114A');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FE946114A');
        $this->addSql('DROP TABLE cr_district');
        $this->addSql('DROP TABLE cr_canton');
        $this->addSql('DROP TABLE cr_province');
        $this->addSql('DROP INDEX IDX_4FBF094FE946114A ON company');
        $this->addSql('DROP INDEX IDX_4FBF094F8D070D0B ON company');
        $this->addSql('DROP INDEX IDX_4FBF094FB08FA272 ON company');
        $this->addSql('ALTER TABLE company DROP province_id, DROP canton_id, DROP district_id, CHANGE alternate alternate VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone01 phone01 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone02 phone02 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE fax fax VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
