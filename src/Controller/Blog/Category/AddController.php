<?php

namespace App\Controller\Blog\Category;

use App\Entity\Blog\Category;
use App\Form\Blog\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/categorie', name: 'app_blog_category_')]
class AddController extends AbstractController
{
    #[Route('/nouvelle', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();

        //$this->denyAccessUnlessGranted('CATEGORY_CREATE', $category);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a bien été ajoutée.');

            return $this->redirectToRoute('app_blog_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
}
