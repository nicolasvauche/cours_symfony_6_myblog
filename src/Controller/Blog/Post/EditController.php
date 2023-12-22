<?php

namespace App\Controller\Blog\Post;

use App\Entity\Blog\Category;
use App\Entity\Blog\Post;
use App\Form\Blog\PostType;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/blog/article', name: 'app_blog_post_')]
class EditController extends AbstractController
{
    #[Route('/{id}/modifier', name: 'edit', methods: ['GET', 'POST'])]
    #[isGranted('ROLE_ADMIN')]
    public function edit(Request                $request,
                         Post                   $post,
                         EntityManagerInterface $entityManager,
                         FileUploaderService    $fileUploaderService): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Gestion du fichier uploadé
            /** @var UploadedFile $coverFile */
            $coverFile = $form->get('cover')->getData();
            if($coverFile) {
                if($post->getCover()) {
                    $fileUploaderService->delete($post->getCover());
                }

                $coverFileName = $fileUploaderService->upload($coverFile);
                $post->setCover($coverFileName);
            }

            // Gestion des catégories existantes
            $submittedCategories = $form->get('categories')->getData();
            foreach($entityManager->getRepository(Category::class)->findAll() as $category) {
                if(!$submittedCategories->contains($category)) {
                    $category->removePost($post);
                } else {
                    $category->addPost($post);
                }
                $entityManager->persist($category);
            }

            // Gestion des nouvelles catégories
            $newCategoryData = $form->get('newCategory')->getData();
            if($newCategoryData) {
                $entityManager->persist($newCategoryData);
                $post->addCategory($newCategoryData);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Article modifié avec succès !');

            return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/post/index/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }
}
