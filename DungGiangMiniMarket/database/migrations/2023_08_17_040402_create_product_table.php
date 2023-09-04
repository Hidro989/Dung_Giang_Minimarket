<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('video')->nullable();
            $table->string('featured_image');
            $table->bigInteger('unit_price')->nullable();
            $table->boolean('is_variant')->default(false);
            $table->string('attribute_ids')->nullable();
            $table->float('weight');
            $table->integer('stock')->nullable();
            $table->date('created_date')->default(now());
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
