<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testDisplayFormLogin()
    {
		$client = static::createClient();
		$client->request('GET', '/login');
		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
	}

    public function testLogin()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "toto@user.fr",
			'password' => "toto",
		]);
        $client->submit($form);
		$this->assertResponseRedirects('/');
    }

	public function testBadLogin()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "toto@user.fr",
			'password' => "bobo",
		]);
		$client->submit($form);
		$this->assertResponseRedirects('/login');
		$client->followRedirect();
		$this->assertSelectorExists('.alert-danger');
	}

	public function testAdminLogin()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "bibi@admin.fr",
			'password' => "bibi",
		]);
        $client->submit($form);
		$this->assertResponseRedirects('/');
    }

	public function testAminBadLogin()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "bibi@admin.fr",
			'password' => "titi",
		]);
		$client->submit($form);
		$this->assertResponseRedirects('/login');
		$client->followRedirect();
		$this->assertSelectorExists('.alert-danger');
	}

	public function testAnonymousLogin()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "anonymous@symfony.com",
			'password' => "anonymous",
		]);
        $client->submit($form);
		$this->assertResponseRedirects('/');
    }

	public function testAnonymousBadLogin()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');
		$form = $crawler->selectButton('Se connecter')->form([
			'email' => "anonymous@symfony.com",
			'password' => "bidule",
		]);
		$client->submit($form);
		$this->assertResponseRedirects('/login');
		$client->followRedirect();
		$this->assertSelectorExists('.alert-danger');
	}

	public function testLogout()
    {
		$client = static::createClient();
        $client->request('GET', '/logout');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
