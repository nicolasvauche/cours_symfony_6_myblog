<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHomepageAnswersCorrectly(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur mon blog !');
    }

    public function testError404(): void
    {
        $client = static::createClient();
        $client->request('GET', '/truc');

        $this->assertResponseStatusCodeSame(404);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
