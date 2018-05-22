<?php

namespace Tests\Browser;

use App\Website;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateProductBrowserTest extends DuskTestCase
{
    use  DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    function an_client_can_create_products()
    {
        $website = factory(Website::class)->create();

        $this->browse(function (Browser $browser) use ($website){
            $browser->loginAs($website->user)
                ->visit(route('products.create', $website))
                ->assertSee('Crear un nuevo producto, articulo o servicio')
                ->pause(100);
        });
    }
}
