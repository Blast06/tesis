<?php

namespace Tests\Feature\Register;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_can_register()
    {
        $this->post('/register', $this->getValidData())
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');

        $this->assertAuthenticated();
    }

    /** @test */
    function guest_can_see_validation_erros()
    {
        $this->post('/register', [])
            ->assertSessionHasErrors(['name','email','password']);

        $this->assertFalse($this->isAuthenticated());
    }




    protected function getValidData(array $custom = [])
    {
        return array_filter(array_merge([
            'name' => 'Cristian Gomez',
            'email' => 'cristiangomeze@example.com',
            'password' => 'L@ravel1',
            'password_confirmation' => 'L@ravel1',
        ], $custom));
    }
}
