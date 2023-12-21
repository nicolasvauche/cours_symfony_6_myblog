<?php

namespace App\EventSubscriber;

use App\Event\FeaturedRetrievedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;

class FeaturedCleanupSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FeaturedRetrievedEvent::NAME => 'onFeaturedRetrieved',
        ];
    }

    public function onFeaturedRetrieved(FeaturedRetrievedEvent $event): void
    {
        foreach($event->getFeatured() as $featured) {
            if($featured->getEndAt() <= new \DateTimeImmutable('now')) {
                $this->entityManager->remove($featured);
            }
        }
        $this->entityManager->flush();
    }
}
