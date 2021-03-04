<?php

namespace App\Tests\Controller;

use App\Tests\Logger\NeedLogin;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends NeedLogin
{
    /**
	 * Test display login form
	 *
	 * @return void
	 */
	public function testDisplayFormLogin()
    {
		$this->client->request('GET', '/login');
		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
	}

	/**
	 * Test login
	 *
	 * @return void
	 */
    public function testLogin()
	{
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "toto@user.fr",
			'password' => "toto",
		]);

        $this->client->submit($form);
		$this->assertResponseRedirects('/');
    }

	/**
	 * Test bad login
	 *
	 * @return void
	 */
	public function testBadLogin()
	{
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "toto@user.fr",
			'password' => "bobo",
		]);

		$this->client->submit($form);
		$this->assertResponseRedirects('/login');
		$this->client->followRedirect();
		$this->assertSelectorExists('.alert-danger');
	}

	/**
	 * Test login admin
	 *
	 * @return void
	 */
	public function testAdminLogin()
	{
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "bibi@admin.fr",
			'password' => "bibi",
		]);

        $this->client->submit($form);
		$this->assertResponseRedirects('/');
    }

	/**
	 * Test bad login admin
	 *
	 * @return void
	 */
	public function testAminBadLogin()
	{
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "bibi@admin.fr",
			'password' => "titi",
		]);

		$this->client->submit($form);
		$this->assertResponseRedirects('/login');
		$this->client->followRedirect();
		$this->assertSelectorExists('.alert-danger');
	}

	/**
	 * Test login anonymous
	 *
	 * @return void
	 */
	public function testAnonymousLogin()
	{
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "anonymous@symfony.com",
			'password' => "anonymous",
		]);

        $this->client->submit($form);
		$this->assertResponseRedirects('/');
    }

	/**
	 * Test bad anonymous login
	 *
	 * @return void
	 */
	public function testAnonymousBadLogin()
	{
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "anonymous@symfony.com",
			'password' => "bidule",
		]);

		$this->client->submit($form);
		$this->assertResponseRedirects('/login');
		$this->client->followRedirect();
		$this->assertSelectorExists('.alert-danger');
	}

	/**
	 * Test logout
	 *
	 * @return void
	 */
	public function testLogout()
    {
        $this->client->request('GET', '/logout');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
