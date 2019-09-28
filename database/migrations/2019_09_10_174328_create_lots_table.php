<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->bigIncrements('id_lot');
            $table->date('elaboration');
            $table->date('expiry');
            $table->integer('quantity')->unsigned();
            $table->boolean('state')->default(true);
            $table->unsignedBigInteger('id_product');
            $table->foreign('id_product')->references('id_product')->on('products');            
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
        Schema::dropIfExists('lots');
    }
}
