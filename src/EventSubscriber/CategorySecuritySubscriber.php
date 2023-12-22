<?php

namespace App\EventSubscriber;

use App\Entity\Blog\Category;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CategorySecuritySubscriber implements EventSubscriber
{
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->checkPermission($args, 'CATEGORY_CREATE');
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->checkPermission($args, 'CATEGORY_EDIT');
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->checkPermission($args, 'CATEGORY_DELETE');
    }

    private function checkPermission(LifecycleEventArgs $args, string $attribute): void
    {
        $entity = $args->getObject();

        if($entity instanceof Category) {
            if(!$this->authorizationChecker->isGranted($attribute, $entity)) {
                throw new AccessDeniedException('Vous n\'avez pas les droits nécessaires pour cette opération.');
            }
        }
    }
}
