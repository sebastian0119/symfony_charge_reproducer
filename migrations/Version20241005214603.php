<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005214603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD user_analysis_id INT NOT NULL DEFAULT "1"');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D05AC9AA FOREIGN KEY (user_analysis_id) REFERENCES user_analysis (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D05AC9AA ON user (user_analysis_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D05AC9AA');
        $this->addSql('DROP INDEX IDX_8D93D649D05AC9AA ON user');
        $this->addSql('ALTER TABLE user DROP user_analysis_id');
    }
}
