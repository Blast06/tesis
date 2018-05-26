<?php

namespace Tests;

use App\User;
use App\Website;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToWebsiteBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function an_user_can_subscribe_to_website()
    {
        $user = factory(User::class)->create();
        $website = factory(Website::class)->create([
            'name' => 'Website'
        ]);

        $this->browse(function (Browser $browser) use ($user, $website) {
            $browser->loginAs($user)
                ->visit("/{$website->username}")
                ->assertSee("Website")
                ->pressAndWaitFor('SUSCRIBIRSE',5)
                ->assertSee('SUSCRITO');

        });
    }

    /**
     * @test
     * @throws \Throwable
     */
    function an_user_can_unsubscribe_to_website()
    {
        $user = factory(User::class)->create();
        $website = factory(Website::class)->create([
            'name' => 'Website'
        ]);

        $user->subscribeTo($website);

        $this->browse(function (Browser $browser) use ($user, $website) {
            $browser->loginAs($user)
                ->visit("/{$website->username}")
                ->assertSee("Website")
                ->press('SUSCRITO')
                ->whenAvailable('.swal-modal', function ($swal) {
                    $swal->assertSee('Cancelar suscripción')
                        ->press('CANCELAR SUSCRIPCION');
                })
                ->waitForText('SUSCRIBIRSE');
        });
    }
}
