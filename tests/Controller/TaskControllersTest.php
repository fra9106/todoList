<?php 

namespace App\Tests\Controller;

use App\Tests\Logger\NeedLogin;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends NeedLogin
{
    /**
     * Test task list autorized user
     *
     * @return void
     */
    public function testTaskList()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test task list done
     *
     * @return void
     */
    public function testTakListDone()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks_done');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test task create
     *
     * @return void
     */
    public function testTaskCreate()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Ajouter')->form([
			'task[title]' => "Une super tâche",
			'task[content]' => "Il était une fois...",
		]);
        
        $this->client->submit($form);
		$this->assertResponseRedirects('/tasks');
		$this->client->followRedirect();
		$this->assertSelectorExists('.alert-success');

    }

    /**
     * Test task edit
     *
     * @return void
     */
    public function testTaskEdit()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/tasks/15/edit');
        $form = $crawler->selectButton('Modifier')->form([
			'task[title]' => "titreTest",
			'task[content]' => "contenuTest",
		]);

		$this->client->submit($form);
		$this->assertResponseRedirects('/tasks');
		$this->client->followRedirect();
		$this->assertSelectorExists('.alert-success');
    }
   
    /**
     * Test task Toggle 
     *
     * @return void
     */
    public function testTaskToggle()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/1/toggle');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test task delete
     *
     * @return void
     */
    public function testTaskDelete()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/15/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert-success');
    }
}