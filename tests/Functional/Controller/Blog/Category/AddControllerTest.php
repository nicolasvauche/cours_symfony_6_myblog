<?php

namespace App\Tests\Functional\Controller\Blog\Category;

use App\Entity\Blog\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddControllerTest extends WebTestCase
{
    private string $path = '/blog/categorie/';
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Category::class);

        foreach($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testAdd()
    {
        $this->client->request('GET', sprintf('%snouvelle', $this->path));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Nouvelle Catégorie');

        $this->client->submitForm('Créer', [
            'category[name]' => 'Catégorie créée',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));

        $categories = $this->repository->findAll();
        self::assertSame('Catégorie créée', $categories[0]->getName());
    }
}
