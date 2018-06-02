<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function client_can_delete_owns_article()
    {
        $article = $this->create(Article::class);

        $this->actingAs($article->website->user)
            ->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
            ])
            ->json('delete', $article->url->delete)
            ->assertSuccessful();

        $this->assertSoftDeleted('articles', [
            'id' => $article->id,
            'name' => $article->name,
            'website_id' => $article->website_id,
        ]);
    }
}
