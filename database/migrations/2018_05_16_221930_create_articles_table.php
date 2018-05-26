<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price',9,2)->nullable();
            $table->integer('stock' )->nullable();
            $table->enum('status', [\App\Article::STATUS_AVAILABLE, \App\Article::STATUS_NOT_AVAILABLE, \App\Article::STATUS_PRIVATE])->default(\App\Article::STATUS_AVAILABLE);
            $table->unsignedInteger('website_id');
            $table->unsignedInteger('sub_category_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('website_id')->references('id')->on('websites');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
