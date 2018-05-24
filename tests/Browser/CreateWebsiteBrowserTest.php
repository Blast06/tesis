<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateWebsiteBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $name = 'Nuevo sitio';
    private $username = 'NewUserName';

    /**
     * @test
     * @throws \Throwable
     */
    function auth_user_can_create_website()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/websites/create')
                ->type('name',$this->name)
                ->type('username',$this->username)
                ->press('Crear Sitio')
                ->pause(100)
                ->assertPathIs('/client/newusername/dashboard');
        });

        $this->assertDatabaseHas('websites',[
            'name' => $this->name,
            'username' => $this->username
        ]);
    }

    /**
     * @test
     * @throws \Throwable
     */
    function guest_cannot_create_website()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/websites/create')
                ->pause(100)
                ->assertDontSee('Crear Sitio Web')
                ->assertPathIs('/login');
        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    function auth_user_can_see_errors_on_website_form()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/websites/create')
                ->press('Crear Sitio')
                ->pause(100)
                ->assertSee('El campo sitio es obligatorio.')
                ->assertSee('El campo usuario es obligatorio.');
        });
    }
}
