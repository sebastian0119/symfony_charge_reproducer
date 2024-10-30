<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200618040336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company ADD credit_days INT NOT NULL, ADD payment_method SMALLINT NOT NULL, ADD accounting_comments VARCHAR(255) DEFAULT NULL, ADD accounting_mail VARCHAR(255) DEFAULT NULL, ADD vat_condition SMALLINT NOT NULL, ADD comments VARCHAR(255) DEFAULT NULL, ADD classification VARCHAR(255) NOT NULL, ADD last_visit DATE DEFAULT NULL, ADD crm_notes LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP credit_days, DROP payment_method, DROP accounting_comments, DROP accounting_mail, DROP vat_condition, DROP comments, DROP classification, DROP last_visit, DROP crm_notes');
    }
}
