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

        $websites = $this->create(Website::class, [], 11);

        foreach ($websites as $website){
            $user->subscribeTo($website);
        }

        $this->browse(function (Browser $browser) use ($user, $websites) {
            $browser->loginAs($user)
                ->visit('/home')
                ->assertSee('SUBSCRIPCIONES')
                ->assertSee($websites[0]->name)
                ->assertSee($websites[1]->name)
                ->assertSee($websites[2]->name)
                ->assertSee($websites[3]->name)
                ->assertSee($websites[4]->name)
                ->assertSee($websites[5]->name)
                ->assertSee($websites[6]->name)
                ->assertSee($websites[7]->name)
                ->assertSee($websites[8]->name)
                ->assertSee($websites[9]->name)
                ->assertDontSee($websites[10]->name);
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

        $websites = $this->create(Website::class, ['user_id' => $user->id], 11);

        $this->browse(function (Browser $browser) use ($user, $websites) {
            $browser->loginAs($user)
                ->visit('/home')
                ->assertSee('SITIOS DE TRABAJO')
                ->assertSee($websites[0]->name)
                ->assertSee($websites[1]->name)
                ->assertSee($websites[2]->name)
                ->assertSee($websites[3]->name)
                ->assertSee($websites[4]->name)
                ->assertSee($websites[5]->name)
                ->assertSee($websites[6]->name)
                ->assertSee($websites[7]->name)
                ->assertSee($websites[8]->name)
                ->assertSee($websites[9]->name)
                ->assertDontSee($websites[10]->name);
        });
    }
}
