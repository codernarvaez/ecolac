<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id_product');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('description');
            $table->double('price', 10, 2);
            $table->string('type');
            $table->string('category');
            $table->json('size')->nullable();
            $table->json('presentation')->nullable();
            $table->boolean('has_iva')->default(false);
            $table->boolean('expires')->default(false);
            $table->boolean('deleted')->default(false);
            $table->uuid('external_id');
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
        Schema::dropIfExists('products');
    }
}
