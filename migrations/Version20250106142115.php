<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Corrected Migration: Fix AUTO_INCREMENT and Foreign Key Constraints
 */
final class Version20250106142115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix AUTO_INCREMENT columns and ensure foreign key constraints reference the correct primary keys.';
    }

    public function up(Schema $schema): void
    {
        // -----------------------------
        // 1. Alter 'avis' Table
        // -----------------------------

        // Drop existing primary key if not 'id_avis'
        $this->addSql('ALTER TABLE avis DROP PRIMARY KEY');

        // Add 'id_avis' as AUTO_INCREMENT and set as primary key
        $this->addSql('ALTER TABLE avis 
            ADD id_avis INT AUTO_INCREMENT NOT NULL, 
            DROP id, 
            CHANGE utilisateur_id id_conducteur INT DEFAULT NULL, 
            CHANGE note note DOUBLE PRECISION NOT NULL, 
            CHANGE avis_type avis_type VARCHAR(50) NOT NULL, 
            ADD PRIMARY KEY (id_avis)');

        // Add Foreign Key Constraints
        $this->addSql('ALTER TABLE avis 
            ADD CONSTRAINT FK_8F91ABF086EDF194 FOREIGN KEY (id_conducteur) REFERENCES utilisateur (id)');

        $this->addSql('ALTER TABLE avis 
            ADD CONSTRAINT FK_8F91ABF0EF2FC27C FOREIGN KEY (id_passager) REFERENCES utilisateur (id)');

        // Create Indexes for Foreign Keys
        $this->addSql('CREATE INDEX IDX_8F91ABF086EDF194 ON avis (id_conducteur)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0EF2FC27C ON avis (id_passager)');

        // -----------------------------
        // 2. Alter 'chat' Table
        // -----------------------------

        // Drop existing Foreign Key Constraint if exists (prevent duplicates)
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY IF EXISTS FK_659DF2AA8805AB2F');

        // Add Foreign Key Constraint referencing 'annonce(idAnnonce)'
        $this->addSql('ALTER TABLE chat 
            ADD CONSTRAINT FK_659DF2AA8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (idAnnonce)');

        // -----------------------------
        // 3. Alter 'chat_participants' Table
        // -----------------------------

        // Drop existing Foreign Key Constraints if they exist
        $this->addSql('ALTER TABLE chat_participants DROP FOREIGN KEY IF EXISTS FK_8F8219131A9A7125');
        $this->addSql('ALTER TABLE chat_participants DROP FOREIGN KEY IF EXISTS FK_8F821913A76ED395');

        // Add Foreign Key Constraints
        $this->addSql('ALTER TABLE chat_participants 
            ADD CONSTRAINT FK_8F8219131A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');

        $this->addSql('ALTER TABLE chat_participants 
            ADD CONSTRAINT FK_8F821913A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');

        // -----------------------------
        // 4. Alter 'paiement' Table
        // -----------------------------

        // Drop existing Foreign Key Constraint
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY IF EXISTS FK_B1DC7A1EB83297E7');

        // Drop existing Primary Key
        $this->addSql('ALTER TABLE paiement DROP PRIMARY KEY');

        // Modify columns and add new AUTO_INCREMENT primary key
        $this->addSql('ALTER TABLE paiement 
            ADD etat VARCHAR(255) NOT NULL, 
            DROP status, 
            CHANGE reservation_id reservation_id INT NOT NULL, 
            CHANGE date_paiement date_paiement VARCHAR(255) NOT NULL, 
            CHANGE montant montant DOUBLE PRECISION NOT NULL, 
            CHANGE mode mode VARCHAR(255) NOT NULL, 
            CHANGE id id_paiement INT AUTO_INCREMENT NOT NULL');

        // Add Foreign Key Constraint referencing 'reservation(id_reservation)'
        $this->addSql('ALTER TABLE paiement 
            ADD CONSTRAINT FK_B1DC7A1EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id_reservation)');

        // Add Primary Key on 'id_paiement'
        $this->addSql('ALTER TABLE paiement ADD PRIMARY KEY (id_paiement)');

        // -----------------------------
        // 5. Alter 'pickup_point' Table
        // -----------------------------

        // Drop existing Foreign Key Constraint if exists
        $this->addSql('ALTER TABLE pickup_point DROP FOREIGN KEY IF EXISTS FK_1467BEE8E6ECF817');

        // Add Foreign Key Constraint referencing 'annonce(idAnnonce)' with ON DELETE CASCADE
        $this->addSql('ALTER TABLE pickup_point 
            ADD CONSTRAINT FK_1467BEE8E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonce (idAnnonce) ON DELETE CASCADE');

        // -----------------------------
        // 6. Alter 'reclamation' Table
        // -----------------------------

        // Add 'status' column
        $this->addSql('ALTER TABLE reclamation ADD status VARCHAR(255) NOT NULL');

        // -----------------------------
        // 7. Alter 'reservation' Table
        // -----------------------------

        // Drop existing Foreign Key Constraints
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY IF EXISTS FK_42C849558805AB2F');

        // Drop existing Indexes
        $this->addSql('DROP INDEX IF EXISTS IDX_42C849558805AB2F ON reservation');
        $this->addSql('DROP INDEX IF EXISTS `primary` ON reservation');

        // Modify columns and add new columns
        $this->addSql('ALTER TABLE reservation 
            ADD nbr_places INT NOT NULL, 
            ADD idAnnonce INT NOT NULL, 
            DROP annonce_id, 
            DROP validite, 
            CHANGE date_reservation date_reservation VARCHAR(255) NOT NULL, 
            CHANGE etat etat VARCHAR(255) NOT NULL, 
            CHANGE id id_reservation INT AUTO_INCREMENT NOT NULL, 
            CHANGE nbrplace passager_id INT NOT NULL');

        // Add Foreign Key Constraints referencing 'utilisateur(id)' and 'annonce(idAnnonce)'
        $this->addSql('ALTER TABLE reservation 
            ADD CONSTRAINT FK_42C8495571A51189 FOREIGN KEY (passager_id) REFERENCES utilisateur (id)');

        $this->addSql('ALTER TABLE reservation 
            ADD CONSTRAINT FK_42C84955E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonce (idAnnonce)');

        // Create Indexes for Foreign Keys
        $this->addSql('CREATE INDEX IDX_42C8495571A51189 ON reservation (passager_id)');
        $this->addSql('CREATE INDEX IDX_42C84955E6ECF817 ON reservation (idAnnonce)');

        // Add Primary Key on 'id_reservation'
        $this->addSql('ALTER TABLE reservation ADD PRIMARY KEY (id_reservation)');

        // -----------------------------
        // 8. Alter 'utilisateur' Table
        // -----------------------------

        // Drop existing Foreign Key Constraints related to 'verification_token' and 'voiture' if any
        // (Assuming these are handled in separate migrations or prior steps)

        // Add 'adresse' column, drop 'username', and modify other columns
        $this->addSql('ALTER TABLE utilisateur 
            ADD adresse VARCHAR(180) DEFAULT NULL, 
            DROP username, 
            CHANGE nom nom VARCHAR(180) NOT NULL, 
            CHANGE prenom prenom VARCHAR(180) NOT NULL, 
            CHANGE telephone telephone VARCHAR(180) NOT NULL, 
            CHANGE email email VARCHAR(180) NOT NULL, 
            CHANGE genre genre VARCHAR(180) NOT NULL, 
            CHANGE profile_pic profile_pic VARCHAR(180) DEFAULT NULL');

        // Rename index for email uniqueness
        $this->addSql('ALTER TABLE utilisateur RENAME INDEX uniq_1d1c63b3e7927c74 TO UNIQ_IDENTIFIER_EMAIL');

        // -----------------------------
        // 9. Add Foreign Key Constraints to Other Tables
        // -----------------------------

        // Add Foreign Key Constraint to 'verification_token' referencing 'utilisateur(id)'
        $this->addSql('ALTER TABLE verification_token 
            ADD CONSTRAINT FK_C1CC006BBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id)');

        // Add Foreign Key Constraint to 'voiture' referencing 'utilisateur(id)'
        $this->addSql('ALTER TABLE voiture 
            ADD CONSTRAINT FK_E9E2810FF16F4AC6 FOREIGN KEY (conducteur_id) REFERENCES utilisateur (id)');

        // Add Foreign Key Constraints to 'waypoint' referencing 'annonce(idAnnonce)' and 'reservation(id_reservation)'
        $this->addSql('ALTER TABLE waypoint 
            ADD CONSTRAINT FK_B3DC5881E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonce (idAnnonce)');

        $this->addSql('ALTER TABLE waypoint 
            ADD CONSTRAINT FK_B3DC58815ADA84A2 FOREIGN KEY (id_reservation) REFERENCES reservation (id_reservation)');

        // Add Foreign Key Constraints to 'waypoint_suggestion' referencing 'annonce(idAnnonce)' and 'reservation(id_reservation)'
        $this->addSql('ALTER TABLE waypoint_suggestion 
            ADD CONSTRAINT FK_82D4CE9E6ECF817 FOREIGN KEY (idAnnonce) REFERENCES annonce (idAnnonce)');

        $this->addSql('ALTER TABLE waypoint_suggestion 
            ADD CONSTRAINT FK_82D4CE95ADA84A2 FOREIGN KEY (id_reservation) REFERENCES reservation (id_reservation)');

        // Add Foreign Key Constraints to 'waypoint_approval' referencing 'waypoint_suggestion(id)' and 'utilisateur(id)'
        $this->addSql('ALTER TABLE waypoint_approval 
            ADD CONSTRAINT FK_3FF024DE7BB1FD97 FOREIGN KEY (waypoint_id) REFERENCES waypoint_suggestion (id)');

        $this->addSql('ALTER TABLE waypoint_approval 
            ADD CONSTRAINT FK_3FF024DE4502E565 FOREIGN KEY (passenger_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // -----------------------------
        // Reverse of 'up' Method
        // -----------------------------

        // -----------------------------
        // 1. Reverse Foreign Key Constraints in 'waypoint_approval' Table
        // -----------------------------
        $this->addSql('ALTER TABLE waypoint_approval DROP FOREIGN KEY FK_3FF024DE7BB1FD97');
        $this->addSql('ALTER TABLE waypoint_approval DROP FOREIGN KEY FK_3FF024DE4502E565');

        // -----------------------------
        // 2. Reverse Foreign Key Constraints in 'waypoint_suggestion' Table
        // -----------------------------
        $this->addSql('ALTER TABLE waypoint_suggestion DROP FOREIGN KEY FK_82D4CE9E6ECF817');
        $this->addSql('ALTER TABLE waypoint_suggestion DROP FOREIGN KEY FK_82D4CE95ADA84A2');

        // -----------------------------
        // 3. Reverse Foreign Key Constraints in 'waypoint' Table
        // -----------------------------
        $this->addSql('ALTER TABLE waypoint DROP FOREIGN KEY FK_B3DC5881E6ECF817');
        $this->addSql('ALTER TABLE waypoint DROP FOREIGN KEY FK_B3DC58815ADA84A2');

        // -----------------------------
        // 4. Reverse Foreign Key Constraints in 'voiture' Table
        // -----------------------------
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FF16F4AC6');

        // -----------------------------
        // 5. Reverse Foreign Key Constraints in 'verification_token' Table
        // -----------------------------
        $this->addSql('ALTER TABLE verification_token DROP FOREIGN KEY FK_C1CC006BBF396750');

        // -----------------------------
        // 6. Reverse Changes in 'utilisateur' Table
        // -----------------------------
        $this->addSql('ALTER TABLE utilisateur 
            DROP adresse, 
            ADD username VARCHAR(255) NOT NULL, 
            CHANGE nom nom VARCHAR(255) NOT NULL, 
            CHANGE prenom prenom VARCHAR(255) NOT NULL, 
            CHANGE telephone telephone VARCHAR(255) NOT NULL, 
            CHANGE email email VARCHAR(255) NOT NULL, 
            CHANGE genre genre VARCHAR(10) NOT NULL, 
            CHANGE profile_pic profile_pic VARCHAR(255) DEFAULT NULL');

        $this->addSql('ALTER TABLE utilisateur RENAME INDEX UNIQ_IDENTIFIER_EMAIL TO uniq_1d1c63b3e7927c74');

        // -----------------------------
        // 7. Reverse Changes in 'reservation' Table
        // -----------------------------
        $this->addSql('ALTER TABLE reservation DROP PRIMARY KEY');
        $this->addSql('DROP INDEX IDX_42C8495571A51189 ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955E6ECF817 ON reservation');

        $this->addSql('ALTER TABLE reservation 
            DROP CONSTRAINT FK_42C8495571A51189, 
            DROP CONSTRAINT FK_42C84955E6ECF817, 
            DROP PRIMARY KEY');

        $this->addSql('ALTER TABLE reservation 
            ADD annonce_id INT DEFAULT NULL, 
            ADD nbrplace INT NOT NULL, 
            ADD validite TINYINT(1) DEFAULT NULL, 
            DROP nbr_places, 
            DROP idAnnonce, 
            CHANGE date_reservation date_reservation DATE NOT NULL, 
            CHANGE etat etat VARCHAR(20) NOT NULL, 
            CHANGE id_reservation id INT AUTO_INCREMENT NOT NULL, 
            CHANGE passager_id nbrplace INT NOT NULL');

        // Re-add Foreign Key Constraint referencing 'annonce(id)'
        $this->addSql('ALTER TABLE reservation 
            ADD CONSTRAINT FK_42C849558805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON UPDATE NO ACTION ON DELETE NO ACTION');

        // Re-add Primary Key on 'id'
        $this->addSql('ALTER TABLE reservation ADD PRIMARY KEY (id)');

        // -----------------------------
        // 8. Reverse Changes in 'paiement' Table
        // -----------------------------
        $this->addSql('ALTER TABLE paiement DROP PRIMARY KEY');
        $this->addSql('DROP INDEX `PRIMARY` ON paiement');

        $this->addSql('ALTER TABLE paiement 
            CHANGE id_paiement id INT AUTO_INCREMENT NOT NULL, 
            DROP etat, 
            ADD status VARCHAR(50) NOT NULL, 
            CHANGE reservation_id reservation_id INT DEFAULT NULL, 
            CHANGE date_paiement date_paiement DATE NOT NULL, 
            CHANGE montant montant BIGINT NOT NULL, 
            CHANGE mode mode VARCHAR(100) NOT NULL');

        // Re-add Foreign Key Constraint referencing 'reservation(id)'
        $this->addSql('ALTER TABLE paiement 
            ADD CONSTRAINT FK_B1DC7A1EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');

        // Re-add Primary Key on 'id'
        $this->addSql('ALTER TABLE paiement ADD PRIMARY KEY (id)');

        // -----------------------------
        // 9. Reverse Changes in 'chat_participants' Table
        // -----------------------------
        $this->addSql('ALTER TABLE chat_participants DROP FOREIGN KEY FK_8F8219131A9A7125');
        $this->addSql('ALTER TABLE chat_participants DROP FOREIGN KEY FK_8F821913A76ED395');

        // Re-add Foreign Key Constraints referencing 'chat(id)' and 'utilisateur(id)'
        $this->addSql('ALTER TABLE chat_participants 
            ADD CONSTRAINT FK_8F8219131A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');

        $this->addSql('ALTER TABLE chat_participants 
            ADD CONSTRAINT FK_8F821913A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');

        // -----------------------------
        // 10. Reverse Changes in 'chat' Table
        // -----------------------------
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA8805AB2F');

        // Re-add Foreign Key Constraint referencing 'annonce(id)'
        $this->addSql('ALTER TABLE chat 
            ADD CONSTRAINT FK_659DF2AA8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');

        // -----------------------------
        // 11. Reverse Changes in 'avis' Table
        // -----------------------------
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF086EDF194');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0EF2FC27C');
        $this->addSql('DROP INDEX IDX_8F91ABF086EDF194 ON avis');
        $this->addSql('DROP INDEX IDX_8F91ABF0EF2FC27C ON avis');

        // Drop 'id_avis' primary key and modify columns back to original
        $this->addSql('ALTER TABLE avis DROP PRIMARY KEY, DROP id_avis');

        // Re-add original 'id' column (assuming it was auto_increment and primary key)
        $this->addSql('ALTER TABLE avis 
            ADD id INT NOT NULL AUTO_INCREMENT, 
            ADD PRIMARY KEY (id), 
            ADD utilisateur_id INT DEFAULT NULL, 
            ADD id_passager INT DEFAULT NULL, 
            ADD avis_type VARCHAR(50) NOT NULL, 
            CHANGE note note VARCHAR(50) DEFAULT NULL');

        // Re-add Foreign Key Constraints referencing 'utilisateur(id)'
        $this->addSql('ALTER TABLE avis 
            ADD CONSTRAINT FK_8F91ABF086EDF194 FOREIGN KEY (id_conducteur) REFERENCES utilisateur (id)');

        $this->addSql('ALTER TABLE avis 
            ADD CONSTRAINT FK_8F91ABF0EF2FC27C FOREIGN KEY (id_passager) REFERENCES utilisateur (id)');

        // Re-create Indexes for Foreign Keys
        $this->addSql('CREATE INDEX IDX_8F91ABF086EDF194 ON avis (id_conducteur)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0EF2FC27C ON avis (id_passager)');
    }
}