<?php

namespace App\Tests\UI\Http\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PortfolioApiTest extends WebTestCase
{
    /** @test  */
    public function portfolio_info_api_success()
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
    public function portfolio_info_api_ko()
    {
        $client = static::createClient();

        // Request a specific endpoint
        $crawler = $client->request('GET', '/api/portfolios/a');

        // Get the response
        $response = $client->getResponse();

        // Assertions
        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals('{}', $response->getContent());
    }
}
