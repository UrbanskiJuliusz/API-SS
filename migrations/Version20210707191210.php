<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707191210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, order_view INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entries (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, company_name VARCHAR(255) NOT NULL, www VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, content VARCHAR(500) NOT NULL, created DATETIME NOT NULL, INDEX IDX_2DF8B3C512469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entries ADD CONSTRAINT FK_2DF8B3C512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entries DROP FOREIGN KEY FK_2DF8B3C512469DE2');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE entries');
    }
}
