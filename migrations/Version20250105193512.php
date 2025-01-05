<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105193512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pickup_point ADD CONSTRAINT FK_1467BEE8E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonce (idAnnonce) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495571A51189 FOREIGN KEY (passager_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonce (idAnnonce)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FF16F4AC6 FOREIGN KEY (conducteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE waypoint ADD CONSTRAINT FK_B3DC5881E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonce (idAnnonce)');
        $this->addSql('ALTER TABLE waypoint ADD CONSTRAINT FK_B3DC58815ADA84A2 FOREIGN KEY (id_reservation) REFERENCES reservation (id_reservation)');
        $this->addSql('ALTER TABLE waypoint_suggestion ADD CONSTRAINT FK_82D4CE9E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonce (idAnnonce)');
        $this->addSql('ALTER TABLE waypoint_suggestion ADD CONSTRAINT FK_82D4CE95ADA84A2 FOREIGN KEY (id_reservation) REFERENCES reservation (id_reservation)');
        $this->addSql('ALTER TABLE waypoint_approval ADD CONSTRAINT FK_3FF024DE7BB1FD97 FOREIGN KEY (waypoint_id) REFERENCES waypoint_suggestion (id)');
        $this->addSql('ALTER TABLE waypoint_approval ADD CONSTRAINT FK_3FF024DE4502E565 FOREIGN KEY (passenger_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pickup_point DROP FOREIGN KEY FK_1467BEE8E6ECF817');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FF16F4AC6');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404FB88E14F');
        $this->addSql('ALTER TABLE waypoint DROP FOREIGN KEY FK_B3DC5881E6ECF817');
        $this->addSql('ALTER TABLE waypoint DROP FOREIGN KEY FK_B3DC58815ADA84A2');
        $this->addSql('ALTER TABLE waypoint_approval DROP FOREIGN KEY FK_3FF024DE7BB1FD97');
        $this->addSql('ALTER TABLE waypoint_approval DROP FOREIGN KEY FK_3FF024DE4502E565');
        $this->addSql('ALTER TABLE waypoint_suggestion DROP FOREIGN KEY FK_82D4CE9E6ECF817');
        $this->addSql('ALTER TABLE waypoint_suggestion DROP FOREIGN KEY FK_82D4CE95ADA84A2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495571A51189');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955E6ECF817');
    }
}
