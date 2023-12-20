<?php

namespace App\Service;

use App\Repository\Blog\CategoryRepository;

class CategoryListingService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}
