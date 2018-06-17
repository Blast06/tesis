<?php

namespace Tests\Browser;

use DB;
use App\{User,Article};
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteArticleToUserBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function an_article_can_be_favorite_to_user()
    {
        $user = $this->create(User::class);
        $article = $this->create(Article::class);

        $this->browse(function (Browser $browser) use ($user, $article) {
            $browser->loginAs($user)
                ->visit($article->url->show)
                ->click('button > i.far.fa-heart')
                ->pause($this->pause_time);
        });

        $this->assertCount(1, collect(DB::table('favorites')->count()));
    }

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function an_article_can_be_unfavorite_to_user()
    {
        $user = $this->create(User::class);
        $article = $this->create(Article::class);

        $user->favoriteTo($article);

        $this->browse(function (Browser $browser) use ($user, $article) {
            $browser->loginAs($user)
                ->visit($article->url->show)
                ->click('button > i.fas.fa-heart')
                ->pause($this->pause_time);
        });

        $this->assertDatabaseEmpty('favorites');
    }
}
