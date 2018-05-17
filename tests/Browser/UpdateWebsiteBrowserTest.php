<?php

namespace Tests\Browser;

use App\User;
use App\Website;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateWebsiteBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function client_can_update_website()
    {
        $website = factory(Website::class)->create();

        $this->browse(function (Browser $browser) use ($website) {
            $browser->loginAs($website->user)
                ->visit("client/{$website->username}/edit")
                ->assertSee("Editar {$website->name}")
                ->type('name', 'New name')
                ->press('Actualizar')
                ->pause(100);
        });

        $this->assertDatabaseHas('websites',[
            'name' => 'New name',
            'username' => $website->username
        ]);
    }

    /**
     * @test
     * @throws \Throwable
     */
    function unauthorize_user_cannot_update_website()
    {
        $website = factory(Website::class)->create();
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($website, $user) {
            $browser->loginAs($user)
                ->visit("client/{$website->username}/edit")
                ->pause(100)
                ->assertPathIs('/home');
        });
    }
}
