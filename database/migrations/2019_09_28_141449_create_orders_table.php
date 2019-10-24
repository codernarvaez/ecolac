<?php

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
            $table->bigIncrements('id_order');
            $table->string('code');
            $table->text('observations')->nullable();
            $table->string('state')->default('pending');
            $table->uuid('external_id');
            $table->timestamps();

            $table->unsignedBigInteger('customer');
            $table->foreign('customer')->references('id_person')->on('people');

            $table->unsignedBigInteger('id_person');
            $table->foreign('id_person')->references('id_person')->on('people');
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
