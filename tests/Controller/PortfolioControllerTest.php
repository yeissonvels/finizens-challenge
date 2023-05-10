<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PortfolioControllerTest extends WebTestCase
{
    /** @test  */
    public function get_portfolio_info_from_api()
    {
        $client = static::createClient();

        // Request a specific endpoint
        $crawler = $client->request('GET', '/api/portfolios/1');

        // Get the response
        $response = $client->getResponse();

        // Assertions
        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('{"allocations":[{"id":1,"shares":3},{"id":2,"shares":4}],"id":1}', $response->getContent());
    }

    /** @test  */
    public function portfolio_info_template()
    {
        $client = static::createClient();

        // Request a specific endpoint
        $crawler = $client->request('GET', '/portfolio/1');

        // Get the response
        $response = $client->getResponse();

        // Assertions
        $this->assertEquals('200', $response->getStatusCode());
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h5', 'Portfolio 1');
        $this->assertSelectorTextContains('b', 'Allocations');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html b:contains("Orders")')->count()
        );
    }
}
