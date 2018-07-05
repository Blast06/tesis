<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\{User, Website};
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SidebarWebsiteBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function an_user_only_can_see_10_website_on_subscripcion()
    {
        $user = $this->create(User::class);

        $website_1 = $this->create(Website::class, ['name' => 'website 1']);
        $website_2 = $this->create(Website::class, ['name' => 'website 2']);

        $user->subscribeTo($website_1);
        $user->subscribeTo($website_2);

        $this->browse(function (Browser $browser) use ($user, $website_1, $website_2) {
            $browser->loginAs($user)
                ->visit('/home')
                ->assertSee('SUBSCRIPCIONES')
                ->assertSee($website_1->name)
                ->assertSee($website_2->name);
        });
    }

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function an_user_only_can_see_10_website_on_work_site()
    {
        $user = $this->create(User::class);

        $website_1 = $this->create(Website::class, [
            'name' => 'website 1',
            'user_id' => $user->id
        ]);

        $website_2 = $this->create(Website::class, [
            'name' => 'website 2',
            'user_id' => $user->id
        ]);

        $this->browse(function (Browser $browser) use ($user, $website_1, $website_2) {
            $browser->loginAs($user)
                ->visit('/home')
                ->assertSee('SITIOS DE TRABAJO')
                ->assertSee($website_1->name)
                ->assertSee($website_2->name);
        });
    }
}
