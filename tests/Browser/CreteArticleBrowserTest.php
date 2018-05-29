<?php

namespace Tests\Browser;

use App\Website;
use App\SubCategory;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreteArticleBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function client_can_create_articles_and_redirect_to_list_of_articles()
    {
        $website = $this->create(Website::class);
        $subCategory = $this->create(SubCategory::class);

        $this->browse(function (Browser $browser) use ($website, $subCategory) {
            $browser->loginAs($website->user)
                ->visit("/client/{$website->username}/articles/create")
                ->type('name', 'Titulo de prueba')
                ->click('.custom-control-label')
                ->type('price', 100)
                ->type('stock', 1)
                ->select('status', 'DISPONIBLE')
                ->type('description', 'Descripcion de prueba....')
                ->press('Crear')
                ->whenAvailable('.swal-modal', function ($swal) {
                    $swal->press('Cancel');
                })
                ->pause(100)
                ->assertPathIs("/client/{$website->username}/articles");
        });

        $this->assertDatabaseHas('articles', [
            'id' => 1,
            'name' => 'Titulo de prueba',
            'slug' => 'titulo-de-prueba',
            'status' => 'DISPONIBLE',
            'price' => 100.00,
            'stock' => 1,
            'website_id' => $website->id
        ]);
    }

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function client_can_create_multiple_articles()
    {
        $website = $this->create(Website::class);
        $subCategory = $this->create(SubCategory::class);

        $this->browse(function (Browser $browser) use ($website, $subCategory) {
            $browser->loginAs($website->user)
                ->visit("/client/{$website->username}/articles/create")
                ->type('name', 'Titulo de prueba')
                ->click('.custom-control-label')
                ->type('price', 100)
                ->type('stock', 1)
                ->select('status', 'DISPONIBLE')
                ->type('description', 'Descripcion de prueba....')
                ->press('Crear')
                ->whenAvailable('.swal-modal', function ($swal) {
                    $swal->press('OK');
                })
                ->pause(100)
                ->assertPathIs("/client/{$website->username}/articles/create");
        });

        $this->assertDatabaseHas('articles', [
            'id' => 1,
            'name' => 'Titulo de prueba',
            'slug' => 'titulo-de-prueba',
            'status' => 'DISPONIBLE',
            'price' => 100.00,
            'stock' => 1,
            'website_id' => $website->id
        ]);
    }
}
