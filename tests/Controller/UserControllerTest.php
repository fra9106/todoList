<?php 

namespace App\Tests\Controller;

use App\Tests\Logger\NeedLogin;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends NeedLogin
{
    /**
     * Test users list
     *
     * @return void
     */
    public function testUserList()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test create user
     *
     * @return void
     */
    public function testUserCreate()
    {
        $this->loginAdmin();
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Ajouter')->form([
			'user[first_name]' => "John",
			'user[last_name]' => "Deuph",
            'user[email]' => "johndeuph@user.fr",
            'user[password][first]' => "john",
            'user[password][second]' => "john",
            'user[roles]' => "ROLE_USER"
		]);
        
        $this->client->submit($form);
		$this->assertResponseRedirects('/login');
		$this->client->followRedirect();
		$this->assertSelectorExists('.alert-success');
    }

    /**
     * Test user edit
     *
     * @return void
     */
    public function testUserEdit()
    {
        $this->loginAdmin();
        $crawler = $this->client->request('GET', '/users/3/edit');
        $form = $crawler->selectButton('Modifier')->form([
			'user[first_name]' => "John",
			'user[last_name]' => "Deuf",
            'user[email]' => "johndeuf@user.fr",
            'user[password][first]' => "john",
            'user[password][second]' => "john",
            'user[roles]' => "ROLE_ADMIN"
		]);
        
        $this->client->submit($form);
		$this->assertResponseRedirects('/users');
		$this->client->followRedirect();
		$this->assertSelectorExists('.alert-success');
    }

    /**
     * Test user delete
     *
     * @return void
     */
    public function testUserDelete()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users/3/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }

}