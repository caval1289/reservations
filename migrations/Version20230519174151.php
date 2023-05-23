<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519174151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_type_show (id INT AUTO_INCREMENT NOT NULL, artistetype_id INT NOT NULL, representations_id INT NOT NULL, INDEX IDX_F9D57781660E9D11 (artistetype_id), INDEX IDX_F9D577815DE745A2 (representations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D57781660E9D11 FOREIGN KEY (artistetype_id) REFERENCES artist_type (id)');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D577815DE745A2 FOREIGN KEY (representations_id) REFERENCES shows (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D57781660E9D11');
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D577815DE745A2');
        $this->addSql('DROP TABLE artist_type_show');
    }
}
