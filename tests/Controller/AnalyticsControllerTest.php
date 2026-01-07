<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnalyticsControllerTest extends WebTestCase
{
    public function testIndexPageIsAccessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/analytics');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Financial');
    }

    public function testEmptyStateMessageIsVisible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/analytics');

        $this->assertSelectorTextContains('h2', 'No data imported yet');
    }

    public function testRedirectAfterPost(): void
    {
        $client = static::createClient();
        $client->request('POST', '/analytics');

        $this->assertResponseRedirects('/analytics');
    }
}
