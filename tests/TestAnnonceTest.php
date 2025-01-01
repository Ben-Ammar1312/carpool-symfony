<?php

namespace App\Tests;

use App\Entity\Annonce;
use App\Entity\Conducteur;
use DateTime;

use PHPUnit\Framework\TestCase;

class TestAnnonceTest extends TestCase
{
    public function testAnnonceEntity(): void
    {
        $annonce = new Annonce();

        // Test ID
        $this->assertNull($annonce->getId());

        // Test Date de départ
        $dateDepart = new DateTime('2024-12-20');
        $annonce->setDateDepart($dateDepart);
        $this->assertSame($dateDepart, $annonce->getDateDepart());

        // Test Nombre de places
        $annonce->setNbrPlace(4);
        $this->assertEquals(4, $annonce->getNbrPlace());

        // Test Lieu de départ
        $annonce->setLieuDepart('Tunis');
        $this->assertEquals('Tunis', $annonce->getLieuDepart());

        // Test Lieu d'arrivée
        $annonce->setLieuArrive('Sousse');
        $this->assertEquals('Sousse', $annonce->getLieuArrive());

        // Test Heure de départ
        $annonce->setHeureDepart('08:30');
        $this->assertEquals('08:30', $annonce->getHeureDepart());

        // Test Description
        $annonce->setDescription('Trajet quotidien pour les étudiants.');
        $this->assertEquals('Trajet quotidien pour les étudiants.', $annonce->getDescription());

        // Test Aller-retour
        $annonce->setAllerRetour('Oui');
        $this->assertEquals('Oui', $annonce->getAllerRetour());

        // Test Régulier
        $annonce->setRegulier(true);
        $this->assertTrue($annonce->isRegulier());

        // Test Prix
        $annonce->setPrix('50');
        $this->assertEquals('50', $annonce->getPrix());

        // Test Conducteur
        $conducteur = new Conducteur();
        $annonce->setConducteur($conducteur);
        $this->assertSame($conducteur, $annonce->getConducteur());
    }
}
