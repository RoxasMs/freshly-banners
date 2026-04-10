<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260410145756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, active TINYINT NOT NULL, internal_name VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, background_color VARCHAR(20) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE banner_content (id INT AUTO_INCREMENT NOT NULL, active_lang TINYINT NOT NULL, content LONGTEXT NOT NULL, banner_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_AA98196A684EC833 (banner_id), INDEX IDX_AA98196A82F1BAF4 (language_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(5) NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE banner_content ADD CONSTRAINT FK_AA98196A684EC833 FOREIGN KEY (banner_id) REFERENCES banner (id)');
        $this->addSql('ALTER TABLE banner_content ADD CONSTRAINT FK_AA98196A82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banner_content DROP FOREIGN KEY FK_AA98196A684EC833');
        $this->addSql('ALTER TABLE banner_content DROP FOREIGN KEY FK_AA98196A82F1BAF4');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE banner_content');
        $this->addSql('DROP TABLE language');
    }
}
