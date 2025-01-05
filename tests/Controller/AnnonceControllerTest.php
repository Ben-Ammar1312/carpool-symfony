<?php

namespace App\Tests\Controller;

use assets\Entity\Annonce;use Doctrine\ORM\EntityManagerInterface;use Doctrine\ORM\EntityRepository;use Symfony\Bundle\FrameworkBundle\KernelBrowser;use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AnnonceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/annonce/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Annonce::class);

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
        self::assertPageTitleContains('Annonce index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'annonce[dateDepart]' => 'Testing',
            'annonce[nbrPlace]' => 'Testing',
            'annonce[lieuDepart]' => 'Testing',
            'annonce[lieuArrive]' => 'Testing',
            'annonce[heureDepart]' => 'Testing',
            'annonce[description]' => 'Testing',
            'annonce[aller_retour]' => 'Testing',
            'annonce[regulier]' => 'Testing',
            'annonce[prix]' => 'Testing',
            'annonce[conducteur]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setDateDepart('My Title');
        $fixture->setNbrPlace('My Title');
        $fixture->setLieuDepart('My Title');
        $fixture->setLieuArrive('My Title');
        $fixture->setHeureDepart('My Title');
        $fixture->setDescription('My Title');
        $fixture->setAller_retour('My Title');
        $fixture->setRegulier('My Title');
        $fixture->setPrix('My Title');
        $fixture->setConducteur('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Annonce');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setDateDepart('Value');
        $fixture->setNbrPlace('Value');
        $fixture->setLieuDepart('Value');
        $fixture->setLieuArrive('Value');
        $fixture->setHeureDepart('Value');
        $fixture->setDescription('Value');
        $fixture->setAller_retour('Value');
        $fixture->setRegulier('Value');
        $fixture->setPrix('Value');
        $fixture->setConducteur('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'annonce[dateDepart]' => 'Something New',
            'annonce[nbrPlace]' => 'Something New',
            'annonce[lieuDepart]' => 'Something New',
            'annonce[lieuArrive]' => 'Something New',
            'annonce[heureDepart]' => 'Something New',
            'annonce[description]' => 'Something New',
            'annonce[aller_retour]' => 'Something New',
            'annonce[regulier]' => 'Something New',
            'annonce[prix]' => 'Something New',
            'annonce[conducteur]' => 'Something New',
        ]);

        self::assertResponseRedirects('/annonce/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateDepart());
        self::assertSame('Something New', $fixture[0]->getNbrPlace());
        self::assertSame('Something New', $fixture[0]->getLieuDepart());
        self::assertSame('Something New', $fixture[0]->getLieuArrive());
        self::assertSame('Something New', $fixture[0]->getHeureDepart());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getAller_retour());
        self::assertSame('Something New', $fixture[0]->getRegulier());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getConducteur());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setDateDepart('Value');
        $fixture->setNbrPlace('Value');
        $fixture->setLieuDepart('Value');
        $fixture->setLieuArrive('Value');
        $fixture->setHeureDepart('Value');
        $fixture->setDescription('Value');
        $fixture->setAller_retour('Value');
        $fixture->setRegulier('Value');
        $fixture->setPrix('Value');
        $fixture->setConducteur('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/annonce/');
        self::assertSame(0, $this->repository->count([]));
    }
}
