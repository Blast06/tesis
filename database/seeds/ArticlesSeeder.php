<?php

use Illuminate\Database\Seeder;
use App\{SubCategory, User, Website, Article};

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Website::truncate();
        Article::truncate();

        $subcategory = SubCategory::all();

        $user = factory(User::class)->create([
            'name' => 'cristian gomez',
            'email' => 'cristiangomeze@hotmail.com'
        ]);

         tap($user->websites()->create([
             'name' => 'Big Sysyem',
             'username' => 'bigsystem'
         ]), function ($website) use ($user, $subcategory){
             $user->subscribeTo($website);

             $website->articles()->create([
                 'name' => "primer articulo {$website->name}",
                 'description' => "Esta es la descripcion del primer articulo de {$website->name}",
                 'price' => 100.00,
                 'sub_category_id' => ($subcategory->random())->id,
                 'status' => Article::STATUS_AVAILABLE
             ]);

             $website->articles()->create([
                 'name' => "segundo articulo {$website->name}",
                 'description' => "Esta es la descripcion del segundo articulo de {$website->name}",
                 'price' => 100.00,
                 'sub_category_id' => ($subcategory->random())->id,
                 'status' => Article::STATUS_AVAILABLE
             ]);

             $website->articles()->create([
                 'name' => "tercer articulo {$website->name}",
                 'description' => "Esta es la descripcion del tercer articulo de {$website->name}",
                 'price' => 100.00,
                 'sub_category_id' => ($subcategory->random())->id,
                 'status' => Article::STATUS_AVAILABLE
             ]);

             $website->articles()->create([
                 'name' => "cuarto articulo {$website->name}",
                 'description' => "Esta es la descripcion del cuarto articulo de {$website->name}",
                 'price' => 100.00,
                 'sub_category_id' => ($subcategory->random())->id,
                 'status' => Article::STATUS_AVAILABLE
             ]);

             $website->articles()->create([
                 'name' => "quinto articulo {$website->name}",
                 'description' => "Esta es la descripcion del quinto articulo de {$website->name}",
                 'price' => 100.00,
                 'sub_category_id' => ($subcategory->random())->id,
                 'status' => Article::STATUS_AVAILABLE
             ]);
        });

        tap($user->websites()->create([
            'name' => 'Un Show Mas',
            'username' => 'regularshow'
        ]), function ($website) use ($user, $subcategory){
            $user->subscribeTo($website);

            $website->articles()->create([
                'name' => "primer articulo {$website->name}",
                'description' => "Esta es la descripcion del primer articulo de {$website->name}",
                'price' => 100.00,
                'sub_category_id' => ($subcategory->random())->id,
                'status' => Article::STATUS_AVAILABLE
            ]);

            $website->articles()->create([
                'name' => "segundo articulo {$website->name}",
                'description' => "Esta es la descripcion del segundo articulo de {$website->name}",
                'price' => 100.00,
                'sub_category_id' => ($subcategory->random())->id,
                'status' => Article::STATUS_AVAILABLE
            ]);

            $website->articles()->create([
                'name' => "tercer articulo {$website->name}",
                'description' => "Esta es la descripcion del tercer articulo de {$website->name}",
                'price' => 100.00,
                'sub_category_id' => ($subcategory->random())->id,
                'status' => Article::STATUS_AVAILABLE
            ]);

            $website->articles()->create([
                'name' => "cuarto articulo {$website->name}",
                'description' => "Esta es la descripcion del cuarto articulo de {$website->name}",
                'price' => 100.00,
                'sub_category_id' => ($subcategory->random())->id,
                'status' => Article::STATUS_AVAILABLE
            ]);

            $website->articles()->create([
                'name' => "quinto articulo {$website->name}",
                'description' => "Esta es la descripcion del quinto articulo de {$website->name}",
                'price' => 100.00,
                'sub_category_id' => ($subcategory->random())->id,
                'status' => Article::STATUS_AVAILABLE
            ]);
        });

    }
}
