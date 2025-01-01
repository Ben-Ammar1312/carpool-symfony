<?php

namespace App\Tests\Controller;

use App\Entity\Paiement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PaiementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/paiement/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Paiement::class);

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
        self::assertPageTitleContains('Paiement index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'paiement[date_paiement]' => 'Testing',
            'paiement[montant]' => 'Testing',
            'paiement[status]' => 'Testing',
            'paiement[mode]' => 'Testing',
            'paiement[reservation]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Paiement();
        $fixture->setDate_paiement('My Title');
        $fixture->setMontant('My Title');
        $fixture->setStatus('My Title');
        $fixture->setMode('My Title');
        $fixture->setReservation('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Paiement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Paiement();
        $fixture->setDate_paiement('Value');
        $fixture->setMontant('Value');
        $fixture->setStatus('Value');
        $fixture->setMode('Value');
        $fixture->setReservation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'paiement[date_paiement]' => 'Something New',
            'paiement[montant]' => 'Something New',
            'paiement[status]' => 'Something New',
            'paiement[mode]' => 'Something New',
            'paiement[reservation]' => 'Something New',
        ]);

        self::assertResponseRedirects('/paiement/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate_paiement());
        self::assertSame('Something New', $fixture[0]->getMontant());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getMode());
        self::assertSame('Something New', $fixture[0]->getReservation());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Paiement();
        $fixture->setDate_paiement('Value');
        $fixture->setMontant('Value');
        $fixture->setStatus('Value');
        $fixture->setMode('Value');
        $fixture->setReservation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/paiement/');
        self::assertSame(0, $this->repository->count([]));
    }
}
