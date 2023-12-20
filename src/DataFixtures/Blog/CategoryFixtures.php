<?php

namespace App\DataFixtures\Blog;

use App\Entity\Blog\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $category = (new Category())
            ->setName('Test');
        $manager->persist($category);
        $this->setReference('category-test', $category);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
