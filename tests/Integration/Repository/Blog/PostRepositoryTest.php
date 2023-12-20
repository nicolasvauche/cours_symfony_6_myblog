<?php

namespace App\Tests\Integration\Repository\Blog;

use App\DataFixtures\Blog\CategoryFixtures;
use App\DataFixtures\Blog\PostFixtures;
use App\Entity\Blog\Post;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private Post $post;

    protected function setUp(): void
    {
        // Récupération de l'EntityMangerInterface
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        // Exécution des fixtures
        $this->loadFixtures();
    }

    private function loadFixtures(): void
    {
        $loader = new Loader();
        $loader->addFixture(new CategoryFixtures());
        $loader->addFixture(new PostFixtures());

        // Purge de la base de données
        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor($this->entityManager, $purger);

        $executor->execute($loader->getFixtures());
    }

    public function testPostCreation()
    {
        // Récupération de l'entité
        $postRepository = $this->entityManager->getRepository(Post::class);
        $this->post = $postRepository->findOneBy(['title' => 'Mon premier article']);

        // Assertions
        $this->assertNotNull($this->post);
        $this->assertEquals('Mon premier article', $this->post->getTitle());
        $this->assertNull($this->post->getCover());
        $this->assertNotNull($this->post->getContent());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->post->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->post->getUpdatedAt());
        $this->assertNull($this->post->getPublishedAt());
    }

    protected function tearDown(): void
    {
        // Nettoyage de la base de données
        /*$this->entityManager->remove($this->post);
        $this->entityManager->flush();*/

        parent::tearDown();

        $this->entityManager->close();
    }
}
