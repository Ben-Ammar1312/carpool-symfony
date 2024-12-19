<?php
namespace App\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class RegisterControllerTest extends WebTestCase
{
    public function testRegistrationPageLoads(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Inscription');
    }
    public function testValidRegistration(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        // Assuming the form has fields with these names:
        $form = $crawler->selectButton("S'inscrire")->form([
            'register_form[nom]' => 'Doe',
            'register_form[prenom]' => 'John',
            'register_form[telephone]' => '0600000000',
            'register_form[email]' => 'john.doe@test.com',
            'register_form[username]' => 'johndoe',
            'register_form[genre]' => 'M',
            'register_form[agreeTerms]' => true,
            'register_form[plainPassword]' => 'password123',
            'register_form[confirm_password]' => 'password123',
            // 'register_form[profilePic]' is optional and may be left blank
        ]);
        $client->submit($form);
        // If registration redirects to login on success:
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorTextContains('.alert-success', 'Inscription réussie !');
    }
    public function testInvalidRegistrationMismatchedPasswords(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton("S'inscrire")->form([
            'register_form[nom]' => 'Doe',
            'register_form[prenom]' => 'John',
            'register_form[telephone]' => '0600000000',
            'register_form[email]' => 'john.doe@test.com',
            'register_form[username]' => 'johndoe',
            'register_form[genre]' => 'M',
            'register_form[agreeTerms]' => true,
            'register_form[plainPassword]' => 'password123',
            'register_form[confirm_password]' => 'wrongpassword',
        ]);
        $client->submit($form);
        // Expecting the controller to add a flash message and redirect back to register
        $this->assertResponseRedirects('/register');
        $client->followRedirect();
        $this->assertSelectorTextContains('.alert-danger', 'Les mots de passe ne correspondent pas.');
    }

}