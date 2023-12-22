<?php

namespace App\Controller\Blog\Post;

use App\Repository\Blog\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/article', name: 'app_blog_post_')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('blog/post/index/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
}
