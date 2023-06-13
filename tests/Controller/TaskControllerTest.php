<?php

namespace App\Tests\Controller;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    private UserRepository $userRepository;
    private TaskRepository $taskRepository;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->taskRepository = static::getContainer()->get(TaskRepository::class);
    }

    public function testList(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $this->client->request('GET', '/tasks');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('button', 'Marquer comme faite');
    }

    public function testCreate(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Ajouter')->form([
                                                            'task[title]' => 'Test Task',
                                                            'task[content]' => 'Test Content',
                                                        ]);
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/tasks'));
        $task = $this->taskRepository->findOneBy(['title' => 'Test Task']);
        $this->assertNotNull($task);
    }

    public function testEdit(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $task = $this->taskRepository->findOneBy(array('users' => $testUser));
        $crawler = $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Modifier')->form([
                                                             'task[title]' => 'Updated Task',
                                                             'task[content]' => 'Updated Content',
                                                         ]);
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/tasks'));
    }

    public function testEditNotOwnedTask(): void
    {
        $testUser = $this->userRepository->findNotAdmin();
        $this->client->loginUser($testUser);
        $task = $this->taskRepository->findOneNotOwnedBy($testUser);
        $this->client->request('GET', '/tasks/' . $task->getId() . '/edit');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

    public function testDelete(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $task = $this->taskRepository->findOneBy(array('users' => $testUser));
        $taskId = $task->getId();
        $this->client->request('POST', '/tasks/' . $task->getId() . '/delete');
        $this->assertTrue($this->client->getResponse()->isRedirect('/tasks'));
        $deletedTask = $this->taskRepository->find($taskId);
        $this->assertNull($deletedTask);
    }

    public function testDeleteNotOwnedTask(): void
    {
        $testUser = $this->userRepository->findNotAdmin();
        $this->client->loginUser($testUser);
        $task = $this->taskRepository->findOneNotOwnedBy($testUser);
        $taskId = $task->getId();
        $this->client->request('POST', '/tasks/' . $task->getId() . '/delete');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
        $deletedTask = $this->taskRepository->find($taskId);
        $this->assertNotNull($deletedTask);
    }

    public function testToggleTask(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $task = $this->taskRepository->findOneBy(['users' => $testUser, 'isDone' => false]);
        $this->client->request('GET', '/tasks/'.$task->getId().'/toggle');
        self::assertResponseRedirects('/tasks');
        $updatedTask = $this->taskRepository->find($task->getId());
        self::assertTrue($updatedTask->isDone());
    }

    public function testListEnding(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $this->client->request('GET', '/tasks/ending');
        self::assertResponseIsSuccessful();
        $doneTask = $this->taskRepository->findOneBy(['isDone' => 1]);
        self::assertSelectorTextContains('h4 a', $doneTask->getTitle());
    }
}
