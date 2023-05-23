<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519174508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_type_show (id INT AUTO_INCREMENT NOT NULL, artistetype_id INT NOT NULL, show_id INT NOT NULL, INDEX IDX_F9D57781660E9D11 (artistetype_id), INDEX IDX_F9D57781D0C1FC64 (show_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D57781660E9D11 FOREIGN KEY (artistetype_id) REFERENCES artist_type (id)');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D57781D0C1FC64 FOREIGN KEY (show_id) REFERENCES shows (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D57781660E9D11');
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D57781D0C1FC64');
        $this->addSql('DROP TABLE artist_type_show');
    }
}
