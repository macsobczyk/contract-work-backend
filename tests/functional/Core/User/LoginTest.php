<?php

namespace App\Tests\Functional\Core\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends ApiTestCase {

	private Client $client;

	protected function setUp(): void {
		parent::setUp();
		$this->client = self::createClient();
	}

	public function testLoginSuccess() {

		$response = $this->client->request('POST', '/auth', [
			'headers' => ['Content-Type' => 'application/json'],
			'json'    => [
				'username' => 'admin',
				'password' => 'password',
			],
		]);

		$json = $response->toArray();
		$this->assertResponseIsSuccessful();
		$this->assertArrayHasKey('token', $json);
	}

	public function testLoginFailure() {
		$response = $this->client->request('POST', '/auth', [
			'headers' => ['Content-Type' => 'application/json'],
			'json'    => [
				'username' => 'non-existing-user',
				'password' => 'password',
			],
		]);

		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
	}
}
