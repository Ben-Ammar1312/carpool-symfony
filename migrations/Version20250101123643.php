<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250101123643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE waypoint (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, reservation_id INT DEFAULT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_B3DC58818805AB2F (annonce_id), INDEX IDX_B3DC5881B83297E7 (reservation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE waypoint ADD CONSTRAINT FK_B3DC58818805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE waypoint ADD CONSTRAINT FK_B3DC5881B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE username username VARCHAR(255) NOT NULL, CHANGE profile_pic profile_pic VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE waypoint DROP FOREIGN KEY FK_B3DC58818805AB2F');
        $this->addSql('ALTER TABLE waypoint DROP FOREIGN KEY FK_B3DC5881B83297E7');
        $this->addSql('DROP TABLE waypoint');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE username username VARCHAR(20) NOT NULL, CHANGE profile_pic profile_pic VARCHAR(255) NOT NULL');
    }
}
