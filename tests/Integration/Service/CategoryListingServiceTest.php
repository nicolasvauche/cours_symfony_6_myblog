<?php

namespace App\Tests\Integration\Service;

use App\DataFixtures\Blog\CategoryFixtures;
use App\Entity\Blog\Category;
use App\Service\CategoryListingService;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryListingServiceTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private CategoryListingService $service;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->service = new CategoryListingService($this->entityManager->getRepository(Category::class));

        $this->loadFixtures();
    }

    private function loadFixtures(): void
    {
        $loader = new Loader();
        $loader->addFixture(new CategoryFixtures());

        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor($this->entityManager, $purger);

        $executor->execute($loader->getFixtures());
    }

    public function testGetCategoriesFromDatabase()
    {
        $categories = $this->service->getCategories();

        $this->assertNotEmpty($categories);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }
}
