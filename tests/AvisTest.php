<?php
namespace App\Tests\Entity;

use assets\Entity\Avis;use PHPUnit\Framework\TestCase;

class AvisTest extends TestCase
{
    public function testAvisCreation(): void
    {
        // Créer une instance de l'entité Avis
        $avis = new Avis();

        // Définir les propriétés
        $avis->setNote('5');

        // Vérifier les valeurs des propriétés
        $this->assertEquals('5', $avis->getNote());
    }
}
