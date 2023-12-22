<?php

namespace App\Controller\Blog\Post;

use App\Entity\Blog\Post;
use App\Form\Blog\PostType;
use App\Repository\Blog\PostRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('blog/post/index/show.html.twig', [
            'post' => $post,
        ]);
    }

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
            /** @var UploadedFile $coverFile */
            $coverFile = $form->get('cover')->getData();
            if($coverFile) {
                if($post->getCover()) {
                    $fileUploaderService->delete($post->getCover());
                }

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

        return $this->render('blog/post/index/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    #[isGranted('ROLE_ADMIN')]
    public function delete(Request                $request,
                           Post                   $post,
                           EntityManagerInterface $entityManager,
                           FileUploaderService    $fileUploaderService): Response
    {
        if($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            if($post->getCover()) {
                $fileUploaderService->delete($post->getCover());
            }

            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
