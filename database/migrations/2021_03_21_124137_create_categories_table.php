<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('_id');
            $table->integer('parent_id');
            $table->string('name');
            $table->json('short_description');
            $table->json('long_description');
            $table->string('featured_image')->nullable();
            $table->string('banner_image_list')->nullable();
            $table->string('images_list')->nullable();
            $table->integer('type');
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
