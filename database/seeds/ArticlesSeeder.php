<?php

use Illuminate\Database\Seeder;
use App\{
    Review, User, Website, Article
};

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
        Artisan::call('medialibrary:clean');
        Artisan::call('medialibrary:clear');

        factory(User::class)->create([
            'name' => 'cristian gomez',
            'email' => 'cristiangomeze@hotmail.com',
        ]);

        factory(User::class)->times(4)->create();

        factory(Website::class)->times(10)->create()->each(function ($website) {
            //$website->addMediaFromUrl(\Faker\Provider\Image::imageUrl(640, 480, 'city'))->toMediaCollection('websites');
            //$website->addMediaFromUrl(\Faker\Provider\Image::imageUrl(1920, 480, 'abstract'))->toMediaCollection('websites_banner');
        });

        factory(Article::class)->times(100)->create()->each(function ($article){
            //$article->addMediaFromUrl(\Faker\Provider\Image::imageUrl(640, 480, 'business'))->toMediaCollection('articles');
        });

        factory(Review::class)->times(500)->create();
    }
}
