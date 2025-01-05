<?php

namespace App\Tests\Controller;

<<<<<<< HEAD
use App\Entity\Reservation;
=======
use assets\Entity\Reservation;
>>>>>>> 2770c5b04fde1c00f85c9278b3448a36307b2bca
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ReservationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/reservation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Reservation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reservation index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'reservation[date_reservation]' => 'Testing',
            'reservation[nbrplace]' => 'Testing',
            'reservation[validite]' => 'Testing',
            'reservation[etat]' => 'Testing',
            'reservation[annonce]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reservation();
        $fixture->setDate_reservation('My Title');
        $fixture->setNbrplace('My Title');
        $fixture->setValidite('My Title');
        $fixture->setEtat('My Title');
        $fixture->setAnnonce('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Reservation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reservation();
        $fixture->setDate_reservation('Value');
        $fixture->setNbrplace('Value');
        $fixture->setValidite('Value');
        $fixture->setEtat('Value');
        $fixture->setAnnonce('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'reservation[date_reservation]' => 'Something New',
            'reservation[nbrplace]' => 'Something New',
            'reservation[validite]' => 'Something New',
            'reservation[etat]' => 'Something New',
            'reservation[annonce]' => 'Something New',
        ]);

        self::assertResponseRedirects('/reservation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate_reservation());
        self::assertSame('Something New', $fixture[0]->getNbrplace());
        self::assertSame('Something New', $fixture[0]->getValidite());
        self::assertSame('Something New', $fixture[0]->getEtat());
        self::assertSame('Something New', $fixture[0]->getAnnonce());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Reservation();
        $fixture->setDate_reservation('Value');
        $fixture->setNbrplace('Value');
        $fixture->setValidite('Value');
        $fixture->setEtat('Value');
        $fixture->setAnnonce('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/reservation/');
        self::assertSame(0, $this->repository->count([]));
    }
}
