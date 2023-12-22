<?php

namespace App\Controller\Blog\Post;

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
class AddController extends AbstractController
{
    #[Route('/nouveau', name: 'new', methods: ['GET', 'POST'])]
    #[isGranted('ROLE_ADMIN')]
    public function new(Request                $request,
                        EntityManagerInterface $entityManager,
                        FileUploaderService    $fileUploaderService): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $coverFile */
            $coverFile = $form->get('cover')->getData();
            if($coverFile) {
                $coverFileName = $fileUploaderService->upload($coverFile);
                $post->setCover($coverFileName);
            }

            $newCategoryData = $form->get('newCategory')->getData();
            if($newCategoryData) {
                $entityManager->persist($newCategoryData);
                $post->addCategory($newCategoryData);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/post/index/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }
}
