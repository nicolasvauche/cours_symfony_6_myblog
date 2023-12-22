<?php

namespace App\Controller\Blog\Post;

use App\Entity\Blog\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/article', name: 'app_blog_post_')]
class ShowController extends AbstractController
{
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('blog/post/index/show.html.twig', [
            'post' => $post,
        ]);
    }
}
