<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\{Article, Review, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanRatingBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test
     * @throws \Throwable
     */
    function guest_cannot_see_form_to_rating()
    {
        $article = $this->create(Article::class);

        $this->browse(function (Browser $browser) use($article) {
            $browser->visitRoute('articles.show', $article->slug)
                ->scrollTo('footer.main')
                ->assertDontSee('Valorar articulo');
        });
    }

    /** @test
     * @throws \Throwable
     */
    function user_can_rating_article()
    {
        $article = $this->create(Article::class);
        $user = $this->create(User::class);

        $this->browse(function (Browser $browser) use($article, $user) {
            $browser->loginAs($user)
                ->visitRoute('articles.show', $article->slug)
                ->scrollTo('button.btn-primary.btn-block')
                ->click('span.vue-star-rating-pointer.vue-star-rating-star')
                ->press('Valorar articulo')
                ->assertSee('Actualizar valoracion');
        });
    }

    /** @test
     * @throws \Throwable
     */
    function user_can_update_rating_article()
    {
        $review = $this->create(Review::class);

        $this->browse(function (Browser $browser) use($review) {
            $browser->loginAs($review->user)
                ->visitRoute('articles.show', $review->article->slug)
                ->scrollTo('button.btn-primary.btn-block')
                ->click('span.vue-star-rating-pointer.vue-star-rating-star')
                ->press('Actualizar valoracion')
                ->assertSee('Actualizar valoracion');
        });

        $this->assertTrue($review->rating !== $review->refresh());
    }
}
