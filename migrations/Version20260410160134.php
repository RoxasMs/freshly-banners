<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260410160134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create color table and migrate banner background color to relation';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, code VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql("INSERT INTO color (id, name, code) VALUES (1, 'Blanco', '#FFFFFF')");

        $this->addSql('ALTER TABLE banner ADD background_color_id INT NOT NULL DEFAULT 1');
        $this->addSql('CREATE INDEX IDX_6F9DB8E7A1A51272 ON banner (background_color_id)');
        $this->addSql('ALTER TABLE banner ADD CONSTRAINT FK_6F9DB8E7A1A51272 FOREIGN KEY (background_color_id) REFERENCES color (id)');

        $this->addSql('ALTER TABLE banner DROP background_color');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE banner DROP FOREIGN KEY FK_6F9DB8E7A1A51272');
        $this->addSql('DROP INDEX IDX_6F9DB8E7A1A51272 ON banner');

        $this->addSql("ALTER TABLE banner ADD background_color VARCHAR(20) NOT NULL DEFAULT '#FFFFFF'");
        $this->addSql('ALTER TABLE banner DROP background_color_id');

        $this->addSql('DROP TABLE color');
    }
}
