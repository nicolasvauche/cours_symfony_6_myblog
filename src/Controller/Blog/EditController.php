<?php

namespace App\Controller\Blog;

use App\Entity\Blog\Category;
use App\Form\Blog\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/categorie', name: 'app_blog_category_')]
class EditController extends AbstractController
{
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
}
