<?php

namespace App\Tests;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UtilisateurRepoTest extends KernelTestCase
{
    public function testSaveAndRetrieveUser(): void
    {
        self::bootKernel();

        $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();

        $user = new Utilisateur();
        $user->setNom('Doe');
        $user->setPrenom('Jane');
        $user->setEmail('jane.doe@example.com');
        $user->setTelephone("0021621247071");
        $user->setUsername("jane.doe");
        $user->setPassword("qwerty");
        $user->setGenre("Homme");
        $user->setProfilePic("/somewhere");
        $user->setRoles(["ROLE_USER", "ROLE_ADMIN"]);

        // Persist and flush
        $entityManager->persist($user);
        $entityManager->flush();

        // Retrieve the user from repository
        $retrievedUser = $entityManager->getRepository(Utilisateur::class)->findOneByEmail('jane.doe@example.com');

        $this->assertNotNull($retrievedUser);
        $this->assertEquals('Jane', $retrievedUser->getPrenom());
    }
}