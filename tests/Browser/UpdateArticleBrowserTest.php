<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\{Article, SubCategory};
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateArticleBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function client_can_update_owns_articles()
    {
        $article = $this->create(Article::class);
        $subCategory = $this->create(SubCategory::class);

        $this->browse(function (Browser $browser) use ($article, $subCategory) {
            $browser->loginAs($article->website->user)
                ->visit("/client/{$article->website->username}/articles/{$article->id}/edit")
                ->type('name', 'Titulo de prueba')
                ->click('.custom-control-label')
                ->type('price', 400)
                ->type('stock', 100)
                ->select('status', 'DISPONIBLE')
                ->type('description', 'Descripcion de prueba....')
                ->press('Actualizar')
                ->pause($this->pause_time);
        });

        $this->assertDatabaseHas('articles', [
            'id' => 1,
            'name' => 'Titulo de prueba',
            'slug' => 'titulo-de-prueba',
            'status' => 'DISPONIBLE',
            'description' => 'Descripcion de prueba....',
            'stock' => 100,
            'website_id' => $article->website->id
        ]);
    }
}
