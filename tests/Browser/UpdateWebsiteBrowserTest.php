<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\{User, Website};
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
                ->pause($this->pause_time);
        });

        $this->assertDatabaseHas('websites',[
            'id' => $website->id,
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
                ->pause($this->pause_time)
                ->assertPathIs('/home');
        });
    }
}
