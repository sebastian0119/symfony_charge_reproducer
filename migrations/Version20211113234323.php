<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211113234323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, short VARCHAR(5) NOT NULL, symbol VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD currency_id INT NOT NULL');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285938248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('CREATE INDEX IDX_E98F285938248176 ON contract (currency_id)');
        $this->addSql("
                INSERT INTO `currency` (`id`, `name`, `short`, `symbol`) VALUES
                (1, 'Colón', 'CRC', '₡'),
                (2, 'Dollar', 'USD', '$'),
                (3, 'Euro', 'EUR', '€');
            ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285938248176');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP INDEX IDX_E98F285938248176 ON contract');
        $this->addSql('ALTER TABLE contract DROP currency_id');
    }
}
