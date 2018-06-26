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
                ->assertSee(str_limit($websites[0]->name, 20, '...'))
                ->assertSee(str_limit($websites[1]->name, 20, '...'))
                ->assertSee(str_limit($websites[2]->name, 20, '...'))
                ->assertSee(str_limit($websites[3]->name, 20, '...'))
                ->assertSee(str_limit($websites[4]->name, 20, '...'))
                ->assertSee(str_limit($websites[5]->name, 20, '...'))
                ->assertSee(str_limit($websites[6]->name, 20, '...'))
                ->assertSee(str_limit($websites[7]->name, 20, '...'))
                ->assertSee(str_limit($websites[8]->name, 20, '...'))
                ->assertSee(str_limit($websites[9]->name, 20, '...'))
                ->assertDontSee(str_limit($websites[10]->name, 20, '...'));
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
                ->assertSee(str_limit($websites[0]->name, 20, '...'))
                ->assertSee(str_limit($websites[1]->name, 20, '...'))
                ->assertSee(str_limit($websites[2]->name, 20, '...'))
                ->assertSee(str_limit($websites[3]->name, 20, '...'))
                ->assertSee(str_limit($websites[4]->name, 20, '...'))
                ->assertSee(str_limit($websites[5]->name, 20, '...'))
                ->assertSee(str_limit($websites[6]->name, 20, '...'))
                ->assertSee(str_limit($websites[7]->name, 20, '...'))
                ->assertSee(str_limit($websites[8]->name, 20, '...'))
                ->assertSee(str_limit($websites[9]->name, 20, '...'))
                ->assertDontSee(str_limit($websites[10]->name, 20, '...'));
        });
    }
}
