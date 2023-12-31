<?php

namespace App\Controller\Blog\Category;

use App\Entity\Blog\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog/categorie', name: 'app_blog_category_')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            //$this->denyAccessUnlessGranted('CATEGORY_DELETE', $category);

            $entityManager->remove($category);
            $entityManager->flush();
        }

        $this->addFlash('success', 'La catégorie a bien été supprimée.');

        return $this->redirectToRoute('app_blog_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
