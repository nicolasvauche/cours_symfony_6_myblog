<?php

namespace App\Controller;

use App\Event\FeaturedRetrievedEvent;
use App\Repository\Blog\FeaturedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FeaturedRepository $featuredRepository, EventDispatcherInterface $eventDispatcher): Response
    {
        $featured = $featuredRepository->findAll();
        $eventDispatcher->dispatch(new FeaturedRetrievedEvent($featured), FeaturedRetrievedEvent::NAME);
        $featured = $featuredRepository->findAll();

        return $this->render('default/index.html.twig', [
            'featured' => $featured,
        ]);
    }
}
