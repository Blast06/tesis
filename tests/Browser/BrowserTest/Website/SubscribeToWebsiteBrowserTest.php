<?php

namespace Tests\Browser\Website;

use App\Models\User;
use App\Models\Website;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToWebsiteBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function user_can_subscribe_to_website()
    {
        $user = factory(User::class)->create();
        $website = factory(Website::class)->create([
            'name' => 'Website'
        ]);

        $this->browse(function (Browser $browser) use ($user, $website) {
            $browser->loginAs($user)
                ->visit("/{$website->username}")
                ->assertSee("Website")
                ->pressAndWaitFor('SUSCRIBIRSE',1000)
                ->assertSee('SUSCRITO');

        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    function guest_cannot_subscribe_to_website()
    {
        $user = factory(User::class)->create();
        $website = factory(Website::class)->create([
            'name' => 'Website'
        ]);

        $this->browse(function (Browser $browser) use ($user, $website) {
            $browser->loginAs($user)
                ->visit("/{$website->username}")
                ->assertSee("Website")
                ->pressAndWaitFor('SUSCRIBIRSE',1000)
                ->assertSee('SUSCRITO');
        });
    }
}
