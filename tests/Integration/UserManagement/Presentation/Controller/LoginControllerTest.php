<?php

namespace Tests\Integration\UserManagement\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function it_should_load_the_login_page()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user-login/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'Tell me who you are?', 
            $crawler->filter('#container .login-wrapper .panel .panel-heading')->text()
        );
    }
}
