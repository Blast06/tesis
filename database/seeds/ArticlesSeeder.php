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

        factory(User::class)->create([
            'name' => 'cristian gomez',
            'email' => 'cristiangomeze@hotmail.com',
        ]);

        factory(User::class)->times(4)->create();
        
        factory(Website::class)->times(10)->create();
        factory(Article::class)->times(100)->create();
    }
}
