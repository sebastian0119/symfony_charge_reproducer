<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001194320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_analysis (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("
                INSERT INTO `user_analysis` (`id`, `description`) VALUES
                (1, 'unassigned'),
                (2, 'architect'),
                (3, 'modeler'),
                (4, 'intern');
            ");
        $this->addSql('ALTER TABLE tracker ADD user_analysis_id INT NOT NULL DEFAULT "1"');
        $this->addSql('ALTER TABLE tracker ADD CONSTRAINT FK_AC632AAFD05AC9AA FOREIGN KEY (user_analysis_id) REFERENCES user_analysis (id)');
        $this->addSql('CREATE INDEX IDX_AC632AAFD05AC9AA ON tracker (user_analysis_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tracker DROP FOREIGN KEY FK_AC632AAFD05AC9AA');
        $this->addSql('DROP TABLE user_analysis');
        $this->addSql('DROP INDEX IDX_AC632AAFD05AC9AA ON tracker');
        $this->addSql('ALTER TABLE tracker DROP user_analysis_id');
    }
}
