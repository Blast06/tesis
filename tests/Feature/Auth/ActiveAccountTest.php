<?php

namespace Tests\Feature\Auth;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActiveAccountTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $url;

    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->create(User::class, [
            'token' => User::generateToken(),
            'verified_at' => null
        ]);

        $this->url = URL::temporarySignedRoute(
            'activate.account', now()->addMinutes(30), ['token' => $this->user->token]
        );
    }

    /** @test */
    function an_user_can_active_account()
    {
        $this->get($this->url)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home')
            ->assertSessionHas(['flash_success' => '¡Tu cuenta ahora está confirmada!']);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'token' => null,
        ]);

        $this->assertAuthenticated();
    }

    /** @test */
    function an_user_cannot_active_account_with_expired_token()
    {
        Carbon::setTestNow(Carbon::parse('+31 minutes'));

        $this->get($this->url)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home')
            ->assertSessionHas(['flash_danger' => 'Token desconocido']);

        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    function the_token_is_case_sensitive()
    {
        $this->withExceptionHandling();

        $url = URL::temporarySignedRoute(
            'activate.account', now()->addMinutes(30), ['token' => strtolower($this->user->token)]
        );

        $this->get($url)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertSee('Parece que has alterado el delicado equilibrio interno de mi ama de llaves.');

        $this->assertFalse($this->isAuthenticated());
    }

}
