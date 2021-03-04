<?php 

namespace App\Tests\Controller;

use App\Tests\Logger\NeedLogin;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends NeedLogin
{
    public function testUserList()
    {
        $this->loginAdmin();
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

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

}