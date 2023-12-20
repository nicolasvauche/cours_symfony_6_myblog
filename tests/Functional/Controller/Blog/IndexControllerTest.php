<?php

namespace App\Tests\Functional\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private string $path = '/blog/categorie/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);

        self::assertPageTitleContains('Les Catégories');
        $this->assertSelectorTextContains('thead th:nth-child(1)', 'Id');
        $this->assertSelectorTextContains('thead th:nth-child(2)', 'Nom');
    }
}
