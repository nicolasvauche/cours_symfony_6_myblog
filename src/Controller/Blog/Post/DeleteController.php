<?php

namespace App\Controller\Blog\Post;

use App\Entity\Blog\Post;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/blog/article', name: 'app_blog_post_')]
class DeleteController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[
        Route('/{id}', name: 'delete', methods: ['POST'])]
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

            $this->addFlash('success', 'Article supprimé avec succès');
        }

        return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
