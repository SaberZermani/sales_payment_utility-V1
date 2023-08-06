<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SalesPaymentApiControllerTest extends WebTestCase
{
    public function testGenerateSalesPayments()
    {
        $client = static::createClient();

        $client->request('POST', '/api/generate-sales-payments', [
            'outputFile' => '/path/to/output/file.csv', // Adjust as needed
        ]);

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        // Assert the expected response content and status
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('data', $data);
        // Add more assertions as needed
    }
}
