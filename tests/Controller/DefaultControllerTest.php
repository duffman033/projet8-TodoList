<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    private UserRepository $userRepository;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    public function testRedirect(): void
    {
        $this->client->request('GET', '/');
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertMatchesRegularExpression('#/login$#', $this->client->getResponse()->headers->get('Location'));
    }

    public function testHomepageForAuthenticatedUser(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $this->client->request('GET', '/');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }
}
