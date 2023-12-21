<?php

namespace App\Tests\Unit\Service;

use App\Repository\Blog\CategoryRepository;
use App\Service\CategoryListingService;
use PHPUnit\Framework\TestCase;

class CategoryListingServiceTest extends TestCase
{
    public function testGetCategories()
    {
        // Création d'un mock pour CategoryRepository
        $categoryRepository = $this->createMock(CategoryRepository::class);
        $categoryRepository->method('findAll')->willReturn(['cat1', 'cat2', 'cat3']);

        // Initialisation du service avec le mock
        $service = new CategoryListingService($categoryRepository);

        // Assertion que getCategories retourne bien les données mockées
        $this->assertEquals(['cat1', 'cat2', 'cat3'], $service->getCategories());
    }
}
