<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921052430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tracker_expense (id INT AUTO_INCREMENT NOT NULL, tracker_id INT NOT NULL, currency_id INT DEFAULT NULL, date DATE NOT NULL, description VARCHAR(100) NOT NULL, travel NUMERIC(5, 1) DEFAULT NULL, refund NUMERIC(8, 2) DEFAULT NULL, INDEX IDX_7A65F04AFB5230B (tracker_id), INDEX IDX_7A65F04A38248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tracker_expense ADD CONSTRAINT FK_7A65F04AFB5230B FOREIGN KEY (tracker_id) REFERENCES tracker (id)');
        $this->addSql('ALTER TABLE tracker_expense ADD CONSTRAINT FK_7A65F04A38248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE tracker_expenses DROP FOREIGN KEY FK_8D7D0275FB5230B');
        $this->addSql('ALTER TABLE tracker_expenses DROP FOREIGN KEY FK_8D7D027538248176');
        $this->addSql('DROP TABLE tracker_expenses');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tracker_expenses (id INT AUTO_INCREMENT NOT NULL, tracker_id INT NOT NULL, currency_id INT DEFAULT NULL, date DATE NOT NULL, description VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, travel NUMERIC(5, 1) DEFAULT NULL, refund NUMERIC(8, 2) DEFAULT NULL, INDEX IDX_8D7D027538248176 (currency_id), INDEX IDX_8D7D0275FB5230B (tracker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tracker_expenses ADD CONSTRAINT FK_8D7D0275FB5230B FOREIGN KEY (tracker_id) REFERENCES tracker (id)');
        $this->addSql('ALTER TABLE tracker_expenses ADD CONSTRAINT FK_8D7D027538248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE tracker_expense DROP FOREIGN KEY FK_7A65F04AFB5230B');
        $this->addSql('ALTER TABLE tracker_expense DROP FOREIGN KEY FK_7A65F04A38248176');
        $this->addSql('DROP TABLE tracker_expense');
    }
}
