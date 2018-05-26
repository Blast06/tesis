<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\{Article, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = $this->create(User::class);
    }

    /** @test */
    function a_gues_cannot_see_home_page()
    {
        $this->withExceptionHandling();

        $this->get('/home')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }


    /** @test */
    function an_authenticated_user_can_see_last_article_of_their_subscriptor()
    {
        $articles_list = collect($this->create(Article::class, [], 2));

        foreach ($articles_list as $article) {
            $this->user->subscribeTo($article->website);
        }

        $this->actingAs($this->user)->get('/home')
            ->assertViewIs('pages.home')
            ->assertViewHas('articles', function($articles) use ($articles_list) {
                return !$articles->contains($articles_list[0])
                    && !$articles->contains($articles_list[1]);
            });
    }
}
