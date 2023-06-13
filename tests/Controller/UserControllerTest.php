<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private UserRepository $userRepository;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    public function testUserList(): void
    {
        $testUser = $this->userRepository->findOneBy(['username' => 'admin']);
        $this->client->loginUser($testUser);
        $this->client->request('GET', '/users');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }

    public function testUserListForUnauthorizedUser(): void
    {
        $testUser = $this->userRepository->findNotAdmin();
        $this->client->loginUser($testUser);
        $this->client->request('GET', '/users');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

    public function testUserCreate(): void
    {
        $testUser = $this->userRepository->findOneBy(['username' => 'admin']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Ajouter')->form([
                                                            'user[username]' => 'TestUser',
                                                            'user[password][first]' => 'TestPassword',
                                                            'user[password][second]' => 'TestPassword',
                                                            'user[email]' => 'testuser@example.com',
                                                            'user[roles]' => 'ROLE_USER'
                                                        ]);
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/users'));
    }

    public function testUserEdit(): void
    {
        $testUser = $this->userRepository->findOneBy(['username' => 'admin']);
        $this->client->loginUser($testUser);
        $userToEdit = $this->userRepository->findNotAdmin();
        $crawler = $this->client->request('GET', '/users/' . $userToEdit->getId() . '/edit');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Modifier')->form([
                                                             'user[username]' => 'UpdatedTestUser',
                                                             'user[password][first]' => 'UpdatedTestPassword',
                                                             'user[password][second]' => 'UpdatedTestPassword',
                                                             'user[email]' => 'updatedtestuser@example.com',
                                                             'user[roles]' => 'ROLE_USER'
                                                         ]);
        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/users'));
    }
}
