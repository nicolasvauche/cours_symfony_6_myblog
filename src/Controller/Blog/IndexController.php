<?php

namespace App\Controller\Blog;

use App\Repository\Blog\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/categorie', name: 'app_blog_category_')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('blog/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
