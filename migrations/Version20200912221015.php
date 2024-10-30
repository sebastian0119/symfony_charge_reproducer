<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200912221015 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_legaltype (id INT AUTO_INCREMENT NOT NULL, short VARCHAR(20) NOT NULL, full VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("
            INSERT INTO `company_legaltype` (`id`, `short`, `full`) VALUES
            (1, 'Céd. id.', 'Cédula física'),
            (2, 'Céd. jur.', 'Cédula jurídica'),
            (3, 'DIMEX', 'DIMEX'),
            (4, 'NITE', 'NITE'),
            (9, 'Id. ext.', 'Identificación extranjera');
        ");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company_legaltype');
    }
}
