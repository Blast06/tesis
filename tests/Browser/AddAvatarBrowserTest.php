<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddAvatarBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function an_user_can_change_avatar()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->create(User::class))
                ->visit('/profiles')
                ->attach('avatar', '/home/cristian/wallpaper/goku_blue_kaio_ken.png')
                ->whenAvailable('.toast-success', function ($toast) {
                    $toast->assertSee('¡Cambió la imagen exitosamente!');
                });
        });
    }
}
