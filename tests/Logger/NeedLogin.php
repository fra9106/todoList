<?php
namespace App\Tests\Logger;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class NeedLogin extends WebTestCase
{

    protected $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }
    
    /**
     * login user
     *
     * @return void
     */
    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $button = $crawler->filter('form');
        $form = $button->form([
            'email' => 'toto@user.fr',
            'password' => 'toto'
        ]);

        $this->client->submit($form);
    }

    /**
     * login admin
     *
     * @return void
     */
    public function loginAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $button = $crawler->filter('form');
        $form = $button->form([
            'email' => 'bibi@admin.fr',
            'password' => 'bibi'
        ]);

        $this->client->submit($form);
    }
}