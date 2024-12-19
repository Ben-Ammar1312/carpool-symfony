<?php

namespace App\Tests\Entity;

use App\Entity\Voiture; // Vérifiez si votre entité `Voiture` est dans ce namespace
use PHPUnit\Framework\TestCase;

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
