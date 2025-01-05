<?php

namespace App\Tests\Entity;

use assets\Entity\Voiture;use PHPUnit\Framework\TestCase;
// Vérifiez si votre entité `Voiture` est dans ce namespace

class VoitureTest extends TestCase
{
    public function testVoitureCreation(): void
    {
        $voiture = new Voiture();
        $voiture->setMarque('Toyota');
        $voiture->setModele('Corolla');
        $voiture->setCouleur('Rouge');

        $this->assertEquals('Toyota', $voiture->getMarque());
        $this->assertEquals('Corolla', $voiture->getModele());
        $this->assertEquals('Rouge', $voiture->getCouleur());
    }
}
