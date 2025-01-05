<?php
namespace App\Tests\Entity;

use assets\Entity\Reservation;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    public function testReservationCreation(): void
    {
        // Créer une instance de l'entité Reservation
        $reservation = new Reservation();

        // Définir les propriétés
        $dateReservation = new \DateTime('2024-12-19');
        $reservation->setDateReservation($dateReservation);
        $reservation->setNbrplace(5);
        $reservation->setValidite(true);
        $reservation->setEtat('confirmée');

        // Vérifier les valeurs des propriétés
        $this->assertEquals($dateReservation, $reservation->getDateReservation());
        $this->assertEquals(5, $reservation->getNbrplace());
        $this->assertTrue($reservation->isValidite());
        $this->assertEquals('confirmée', $reservation->getEtat());
    }
}
