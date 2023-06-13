<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    private UserRepository $userRepository;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    public function testLoginPageForUnauthenticatedUser(): void
    {
        $this->client->request('GET', '/login');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('button', 'Se connecter');
    }

    public function testRedirectToDefaultPageForAuthenticatedUser(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $this->client->request('GET', '/login');
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertMatchesRegularExpression('#/$#', $this->client->getResponse()->headers->get('Location'));
    }

    public function testLoginWithBadCredentials(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'non_existent_user';
        $form['_password'] = 'wrong_password';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertSelectorExists('div.alert.alert-danger');
    }

    public function testLogout(): void
    {
        $testUser = $this->userRepository->findOneBy(array('username' => 'admin'));
        $this->client->loginUser($testUser);
        $this->client->request('GET', '/logout');
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->assertMatchesRegularExpression('#/login$#', $this->client->getResponse()->headers->get('Location'));
    }
}
