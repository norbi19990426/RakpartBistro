<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('vezeteknev');
            $table->string('keresztnev');
            $table->string('iranyitoszam');
            $table->string('varos');
            $table->string('email');
            $table->string('address');
            $table->string('telefonszam');
            $table->longtext('message')->nullable();
            $table->Integer('totalPrice');
            $table->unsignedBigInteger('status')->default(1);
            $table->integer('coupon_id')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
