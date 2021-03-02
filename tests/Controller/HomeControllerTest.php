<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();
        $client->request('GET', '/');
       

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);  
        $this->assertEquals(200, $client->getResponse()->getStatusCode());// idem
       
    }

    public function testContentPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(1, $crawler->filter('h1')->count());
        $this->assertSame(4, $crawler->filter('a.btn')->count());
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
        

    }
    
}
