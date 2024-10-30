<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919171057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tracker (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date DATE NOT NULL, comment VARCHAR(255) DEFAULT NULL, submitted TINYINT(1) NOT NULL, authorized TINYINT(1) NOT NULL, authorized_by VARCHAR(30) DEFAULT NULL, authorized_on DATETIME DEFAULT NULL, INDEX IDX_AC632AAFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tracker ADD CONSTRAINT FK_AC632AAFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE company DROP classification');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tracker DROP FOREIGN KEY FK_AC632AAFA76ED395');
        $this->addSql('DROP TABLE tracker');
        $this->addSql('ALTER TABLE company ADD classification LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
