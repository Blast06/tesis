<?php

use App\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price',9,2)->nullable();
            $table->enum('status', [Order::STATUS_WAIT, Order::STATUS_CURRENT, Order::STATUS_COMPLETE, Order::STATUS_CANCEL])->default(Order::STATUS_WAIT);
            $table->integer('quantity');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('website_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('website_id')->references('id')->on('websites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
