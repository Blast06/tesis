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
        $user = $this->create(User::class);

        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user)
                ->visit('/profiles')
                ->attach('avatar', '/home/cristian/Imágenes/goku_blue_kaio_ken.png')
                ->whenAvailable('.toast-success', function ($toast) {
                    $toast->assertSee('¡Cambió la imagen exitosamente!');
                });
        });
    }
}
