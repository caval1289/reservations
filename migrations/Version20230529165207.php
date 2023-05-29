<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529165207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D577817203D2A4');
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D57781AD7ED998');
        $this->addSql('DROP INDEX IDX_F9D577817203D2A4 ON artist_type_show');
        $this->addSql('DROP INDEX IDX_F9D57781AD7ED998 ON artist_type_show');
        $this->addSql('ALTER TABLE artist_type_show ADD artistetype_id INT NOT NULL, ADD show_id INT NOT NULL, DROP artist_type_id, DROP shows_id');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D57781660E9D11 FOREIGN KEY (artistetype_id) REFERENCES artist_type (id)');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D57781D0C1FC64 FOREIGN KEY (show_id) REFERENCES shows (id)');
        $this->addSql('CREATE INDEX IDX_F9D57781660E9D11 ON artist_type_show (artistetype_id)');
        $this->addSql('CREATE INDEX IDX_F9D57781D0C1FC64 ON artist_type_show (show_id)');
        $this->addSql('ALTER TABLE users ADD reset_token VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D57781660E9D11');
        $this->addSql('ALTER TABLE artist_type_show DROP FOREIGN KEY FK_F9D57781D0C1FC64');
        $this->addSql('DROP INDEX IDX_F9D57781660E9D11 ON artist_type_show');
        $this->addSql('DROP INDEX IDX_F9D57781D0C1FC64 ON artist_type_show');
        $this->addSql('ALTER TABLE artist_type_show ADD artist_type_id INT NOT NULL, ADD shows_id INT NOT NULL, DROP artistetype_id, DROP show_id');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D577817203D2A4 FOREIGN KEY (artist_type_id) REFERENCES artist_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE artist_type_show ADD CONSTRAINT FK_F9D57781AD7ED998 FOREIGN KEY (shows_id) REFERENCES shows (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F9D577817203D2A4 ON artist_type_show (artist_type_id)');
        $this->addSql('CREATE INDEX IDX_F9D57781AD7ED998 ON artist_type_show (shows_id)');
        $this->addSql('ALTER TABLE users DROP reset_token');
    }
}
