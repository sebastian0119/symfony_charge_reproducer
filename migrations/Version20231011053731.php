<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011053731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge ADD company_legaltype_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE charge ADD CONSTRAINT FK_556BA4342E847BA5 FOREIGN KEY (company_legaltype_id) REFERENCES company_legaltype (id)');
        $this->addSql('CREATE INDEX IDX_556BA4342E847BA5 ON charge (company_legaltype_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charge DROP FOREIGN KEY FK_556BA4342E847BA5');
        $this->addSql('DROP INDEX IDX_556BA4342E847BA5 ON charge');
        $this->addSql('ALTER TABLE charge DROP company_legaltype_id');
    }
}
