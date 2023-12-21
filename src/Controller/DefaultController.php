<?php

namespace App\Controller;

use App\Repository\Blog\FeaturedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FeaturedRepository $featuredRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'featured' => $featuredRepository->findAll(),
        ]);
    }
}
