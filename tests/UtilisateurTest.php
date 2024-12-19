<?php

namespace App\Tests;

use App\Entity\Utilisateur;
use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $user = new Utilisateur();

        $user->setNom('Doe');
        $this->assertEquals('Doe', $user->getNom());

        $user->setPrenom('John');
        $this->assertEquals('John', $user->getPrenom());

        $user->setEmail('john.doe@example.com');
        $this->assertEquals('john.doe@example.com', $user->getEmail());

        $user->setProfilePic('/images/default-profile.png');
        $this->assertEquals('/images/default-profile.png', $user->getProfilePic());
    }
}