<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id_sale');
            $table->string('code', 10);
            $table->double('total', 10, 2);
            $table->string('payment_method')->nullable();
            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('sales');
    }
}
