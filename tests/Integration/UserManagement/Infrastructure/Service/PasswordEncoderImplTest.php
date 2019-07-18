<?php

namespace Tests\Integration\UserManagement\Infrastructure\Persistence\Doctrine;

use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

use Tests\Integration\IntegrationTestBase;

use UserManagement\Infrastructure\Service\PasswordEncoderImpl;

class PasswordEncoderImplTest extends IntegrationTestBase
{
    protected $mockPlainTextPassword = 'P@ssw0rd!';

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_should_encode_plain_text_password()
    {
        $passwordEncoder = new PasswordEncoderImpl(new BCryptPasswordEncoder(8)); 
        
        $encoded = $passwordEncoder->encodePlainText($this->mockPlainTextPassword);

        $this->assertTrue(! empty($encoded));
    }

    /**
     * @test
     */
    public function it_should_verify_encoded_text_password_against_plain_text_password()
    {
        $passwordEncoder = new PasswordEncoderImpl(new BCryptPasswordEncoder(8)); 
        
        $encoded = $passwordEncoder->encodePlainText($this->mockPlainTextPassword);

        $this->assertTrue($passwordEncoder->verifyEncodedText($encoded, $this->mockPlainTextPassword));    
    }
}
