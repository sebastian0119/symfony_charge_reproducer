<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921034721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tracker_expenses (id INT AUTO_INCREMENT NOT NULL, tracker_id INT NOT NULL, currency_id INT DEFAULT NULL, date DATE NOT NULL, description VARCHAR(100) NOT NULL, travel NUMERIC(5, 1) DEFAULT NULL, refund NUMERIC(8, 2) DEFAULT NULL, INDEX IDX_8D7D0275FB5230B (tracker_id), INDEX IDX_8D7D027538248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tracker_expenses ADD CONSTRAINT FK_8D7D0275FB5230B FOREIGN KEY (tracker_id) REFERENCES tracker (id)');
        $this->addSql('ALTER TABLE tracker_expenses ADD CONSTRAINT FK_8D7D027538248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tracker_expenses DROP FOREIGN KEY FK_8D7D0275FB5230B');
        $this->addSql('ALTER TABLE tracker_expenses DROP FOREIGN KEY FK_8D7D027538248176');
        $this->addSql('DROP TABLE tracker_expenses');
    }
}
