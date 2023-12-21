<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class FeaturedRetrievedEvent extends Event
{
    public const NAME = 'featured.retrieved';

    private array $featured;

    public function __construct(array $featured)
    {
        $this->featured = $featured;
    }

    public function getFeatured(): array
    {
        return $this->featured;
    }
}
