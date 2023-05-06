<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505223246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_type (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_3060D1B6C54C8C93 (type_id), INDEX IDX_3060D1B6B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artists (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(60) NOT NULL, lastname VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localities (id INT AUTO_INCREMENT NOT NULL, postal_code VARCHAR(6) NOT NULL, locality VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, locality_id INT DEFAULT NULL, slug VARCHAR(60) NOT NULL, designation VARCHAR(60) NOT NULL, adress VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, INDEX IDX_17E64ABA88823A92 (locality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE representation_user (id INT AUTO_INCREMENT NOT NULL, representation_id INT NOT NULL, user_id INT NOT NULL, places INT NOT NULL, INDEX IDX_979840A446CE82F4 (representation_id), INDEX IDX_979840A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE representations (id INT AUTO_INCREMENT NOT NULL, the_show_id INT DEFAULT NULL, the_location_id INT DEFAULT NULL, schedule DATETIME NOT NULL, INDEX IDX_C90A4013013D282 (the_show_id), INDEX IDX_C90A401D48E1165 (the_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, representation_id INT NOT NULL, places SMALLINT NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C8495546CE82F4 (representation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shows (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, slug VARCHAR(60) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, poster_url VARCHAR(255) DEFAULT NULL, bookable TINYINT(1) NOT NULL, price NUMERIC(12, 2) DEFAULT NULL, INDEX IDX_6C3BF14464D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_artist_type (show_id INT NOT NULL, artist_type_id INT NOT NULL, INDEX IDX_9F6421FED0C1FC64 (show_id), INDEX IDX_9F6421FE7203D2A4 (artist_type_id), PRIMARY KEY(show_id, artist_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, login VARCHAR(30) NOT NULL, firstname VARCHAR(60) NOT NULL, lastname VARCHAR(60) NOT NULL, language VARCHAR(2) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artist_type ADD CONSTRAINT FK_3060D1B6C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE artist_type ADD CONSTRAINT FK_3060D1B6B7970CF8 FOREIGN KEY (artist_id) REFERENCES artists (id)');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA88823A92 FOREIGN KEY (locality_id) REFERENCES localities (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE representation_user ADD CONSTRAINT FK_979840A446CE82F4 FOREIGN KEY (representation_id) REFERENCES representations (id)');
        $this->addSql('ALTER TABLE representation_user ADD CONSTRAINT FK_979840A4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE representations ADD CONSTRAINT FK_C90A4013013D282 FOREIGN KEY (the_show_id) REFERENCES shows (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE representations ADD CONSTRAINT FK_C90A401D48E1165 FOREIGN KEY (the_location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495546CE82F4 FOREIGN KEY (representation_id) REFERENCES representations (id)');
        $this->addSql('ALTER TABLE shows ADD CONSTRAINT FK_6C3BF14464D218E FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE show_artist_type ADD CONSTRAINT FK_9F6421FED0C1FC64 FOREIGN KEY (show_id) REFERENCES shows (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE show_artist_type ADD CONSTRAINT FK_9F6421FE7203D2A4 FOREIGN KEY (artist_type_id) REFERENCES artist_type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist_type DROP FOREIGN KEY FK_3060D1B6C54C8C93');
        $this->addSql('ALTER TABLE artist_type DROP FOREIGN KEY FK_3060D1B6B7970CF8');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA88823A92');
        $this->addSql('ALTER TABLE representation_user DROP FOREIGN KEY FK_979840A446CE82F4');
        $this->addSql('ALTER TABLE representation_user DROP FOREIGN KEY FK_979840A4A76ED395');
        $this->addSql('ALTER TABLE representations DROP FOREIGN KEY FK_C90A4013013D282');
        $this->addSql('ALTER TABLE representations DROP FOREIGN KEY FK_C90A401D48E1165');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495546CE82F4');
        $this->addSql('ALTER TABLE shows DROP FOREIGN KEY FK_6C3BF14464D218E');
        $this->addSql('ALTER TABLE show_artist_type DROP FOREIGN KEY FK_9F6421FED0C1FC64');
        $this->addSql('ALTER TABLE show_artist_type DROP FOREIGN KEY FK_9F6421FE7203D2A4');
        $this->addSql('DROP TABLE artist_type');
        $this->addSql('DROP TABLE artists');
        $this->addSql('DROP TABLE localities');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE representation_user');
        $this->addSql('DROP TABLE representations');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE shows');
        $this->addSql('DROP TABLE show_artist_type');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
