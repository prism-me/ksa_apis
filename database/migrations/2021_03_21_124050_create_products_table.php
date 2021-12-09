<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->bigInteger('product_code');
            $table->bigIncrements('category_id');
            $table->json('description');
            $table->string('featured_image')->nullable();
            $table->string('banner_image_list')->nullable();
            $table->string('images_list')->nullable();
            $table->json('overview')->nullable();
            $table->json('features')->nullable();
            $table->json('specifications')->nullable();
            $table->string('download');
            $table->integer('type');
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
