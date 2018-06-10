<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function a_guest_can_login()
    {
        $user = $this->create(User::class);

        $this->browse(function (Browser $browser) use ($user){
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Acceder')
                ->pause($this->pause_time)
                ->assertAuthenticated();
        });
    }

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function a_guest_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'cristian')
                ->type('email', 'cristiangomeze@example.com')
                ->type('password', 'L@ravel1')
                ->type('password_confirmation', 'L@ravel1')
                ->press('Registro')
                ->pause($this->pause_time)
                ->assertAuthenticated();
        });
    }

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function an_user_can_logout()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($user = $this->create(User::class))
                ->visit('/home')
                ->clickLink($user->name)
                ->clickLink('Cerrar sesión')
                ->pause($this->pause_time)
                ->assertGuest();
        });
    }
}
