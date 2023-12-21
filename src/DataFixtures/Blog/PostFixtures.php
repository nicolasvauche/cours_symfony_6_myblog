<?php

namespace App\DataFixtures\Blog;

use App\Entity\Blog\Featured;
use App\Entity\Blog\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $post = (new Post())
            ->setTitle('Mon premier article')
            ->setContent(<<<EOF
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, cum eligendi facilis, itaque natus necessitatibus nemo officiis quaerat rerum sequi sint veritatis, vero vitae? Architecto assumenda enim expedita illum totam.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, exercitationem, facilis. Beatae cupiditate deserunt dignissimos eum exercitationem fuga, hic id mollitia natus nemo nobis obcaecati perferendis perspiciatis quaerat quasi sequi!</p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis dolor error laboriosam maxime minus optio, quaerat sequi sint vel voluptates! Accusantium animi asperiores at id iure maiores ratione rerum saepe.</p>
EOF
            )
            ->addCategory($this->getReference('category-test'))
            ->setPublishedAt(new \DateTimeImmutable('-1 day'));
        $manager->persist($post);

        $featured = (new Featured())
            ->setPost($post)
            ->setEndAt(new \DateTimeImmutable('+1 hour'));
        $manager->persist($featured);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}
