<?php

namespace App\Tests;

use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnnonceRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;


    protected function setUp(): void
    {
        self::bootKernel(); // Boot the Symfony kernel
        $this->entityManager = self::getContainer()->get('doctrine')->getManager(); // Get the EntityManager
        $this->repository = $this->entityManager->getRepository(Annonce::class); // Get the repository
    }

    // Test case for finding an annonce by a specific field (e.g., title)
    public function testFindByExampleField(): void
    {
        // Create a new Annonce object
        $annonce = new Annonce();
        $annonce->setTitle('Test Title');
        $annonce->setExampleField('example_value'); // Assuming you have this field in your entity

        // Persist the Annonce object in the database
        $this->entityManager->persist($annonce);
        $this->entityManager->flush();

        // Call the method we want to test
        $results = $this->repository->findByExampleField('example_value');

        // Assert that one result was returned
        $this->assertCount(1, $results);
        $this->assertSame('Test Title', $results[0]->getTitle());
    }

    // Test case for finding a single annonce by a specific field
    public function testFindOneBySomeField(): void
    {
        // Create a new Annonce object
        $annonce = new Annonce();
        $annonce->setTitle('Unique Test');
        $annonce->setExampleField('unique_value');

        // Persist the Annonce object in the database
        $this->entityManager->persist($annonce);
        $this->entityManager->flush();

        // Call the method to test
        $result = $this->repository->findOneBySomeField('unique_value');

        // Assert that the result is not null and has the expected title
        $this->assertNotNull($result);
        $this->assertSame('Unique Test', $result->getTitle());
    }

    // Clean up after each test
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close(); // Close the EntityManager
        $this->entityManager = null; // Clear the EntityManager to avoid memory leaks
    }
}
