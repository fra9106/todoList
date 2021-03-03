<?php 

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskController extends WebTestCase
{
    public function testTaskListNoAurenticated()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testAuthPageRestricted()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
    
    public function testRedirectLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks');

        $this->assertResponseRedirects('/login');
    }
}