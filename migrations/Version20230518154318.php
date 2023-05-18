<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518154318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_type_show (id INT AUTO_INCREMENT NOT NULL, artist_type_id INT NOT NULL, shows_id INT NOT NULL, INDEX IDX_F9D577817203D2A4 (artist_type_id), INDEX IDX_F9D57781AD7ED998 (shows_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D577817203D2A4 FOREIGN KEY (artist_type_id) REFERENCES artist_type (id)');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D57781AD7ED998 FOREIGN KEY (shows_id) REFERENCES shows (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D577817203D2A4');
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D57781AD7ED998');
        $this->addSql('DROP TABLE artist_type_show');
    }
}
