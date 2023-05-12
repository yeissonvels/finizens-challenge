<?php

namespace App\Tests\UI\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PortfolioControllerTest extends WebTestCase
{
    /** @test  */
    public function portfolio_info_template_success()
    {
        $client = static::createClient();

        // Request a specific endpoint
        $crawler = $client->request('GET', '/portfolio/1');

        // Get the response
        $response = $client->getResponse();

        // Assertions
        $this->assertEquals('200', $response->getStatusCode());
        $this->assertResponseIsSuccessful();
        $this->assertGreaterThan(
            0,
            $crawler->filter('html h5.card-header:contains("Create sales order")')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html h5.card-header:contains("Create buy order")')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html h5:contains("Portfolio 1")')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html b:contains("Allocations")')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html b:contains("Orders")')->count()
        );
    }

    /** @test  */
    public function portfolio_info_template_ko()
    {
        $client = static::createClient();

        // Request a specific endpoint
        $crawler = $client->request('GET', '/portfolio/a');

        // Get the response
        $response = $client->getResponse();

        // Assertions
        $this->assertEquals('200', $response->getStatusCode());
        $this->assertResponseIsSuccessful();
        $this->assertGreaterThan(
            0,
            $crawler->filter('html div.alert.alert-danger:contains("Portfolio not found!")')->count()
        );
    }
}
