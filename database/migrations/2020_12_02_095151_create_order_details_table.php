<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('random_string')->nullable();
            $table->decimal('amount',10,2)->default(0);
            $table->decimal('total',10,2)->default(0);
            $table->decimal('tax_per',10,2)->default(0);
            $table->decimal('tax_amount',10,2)->default(0);
            $table->string('paymentMethod')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('orderstatus')->default('pedning');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('order_details');
    }
}
