<?php

namespace App\Tests\Functional\Controller\Blog;

use App\Entity\Blog\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditControllerTest extends WebTestCase
{
    private string $path = '/blog/categorie/';
    private EntityManagerInterface $manager;
    private EntityRepository $repository;

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

    public function testEdit()
    {
        $category = new Category();
        $category->setName('Catégorie créée');
        $this->manager->persist($category);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/modifier', $this->path, $category->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Modifier une Catégorie');

        $this->client->submitForm('Modifier', [
            'category[name]' => 'Catégorie modifiée',
        ]);

        self::assertResponseRedirects($this->path);

        $categories = $this->repository->findAll();
        self::assertSame('Catégorie modifiée', $categories[0]->getName());
    }
}
