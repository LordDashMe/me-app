<?php

namespace Tests\Integration\UserManagement\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function it_should_load_the_registration_page()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user-registration/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'Upon registration', 
            $crawler->filter('#container .login-wrapper .panel .panel-heading')->text()
        );
    }
}
