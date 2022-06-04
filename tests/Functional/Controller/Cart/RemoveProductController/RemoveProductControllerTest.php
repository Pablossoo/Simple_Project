<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\RemoveProductController;

use App\Tests\Functional\WebTestCase;

class RemoveProductControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new RemoveProductControllerFixture());
    }

    public function testRemovesProductFormCart(): void
    {
        $this->client->request('DELETE', '/cart/97e385fe-9876-45fc-baa0-4f2f0df90950/d11e1e69-cca7-40a1-8273-9d93c8346efd');
        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/cart/97e385fe-9876-45fc-baa0-4f2f0df90950');
        self::assertResponseStatusCodeSame(200);
        $response = $this->getJsonResponse();
        self::assertCount(0, $response['products']);
    }

    public function testIgnoresRequestIfProductIsNotInCart(): void
    {
        $this->client->request('DELETE', '/cart/97e385fe-9876-45fc-baa0-4f2f0df90950/7bcf6fe9-e831-4776-a9df-76a702233adc');
        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/cart/97e385fe-9876-45fc-baa0-4f2f0df90950');
        self::assertResponseStatusCodeSame(200);
        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
    }

    public function testIgnoresRequestIfProductDoesNotExist(): void
    {
        $this->client->request('DELETE', '/cart/97e385fe-9876-45fc-baa0-4f2f0df90950/c8faa690-8a6d-4255-90d9-982c0fa58617');
        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/cart/97e385fe-9876-45fc-baa0-4f2f0df90950');
        self::assertResponseStatusCodeSame(200);
        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
    }

    public function testReturns404IfCartDoesNotExist(): void
    {
        $this->client->request('DELETE', '/cart/46750c8e-41fe-4046-b237-8867cdb62a75/d11e1e69-cca7-40a1-8273-9d93c8346efd');
        self::assertResponseStatusCodeSame(404);
    }
}
