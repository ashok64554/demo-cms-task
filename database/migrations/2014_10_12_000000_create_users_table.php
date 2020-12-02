<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('userType', ['admin','user','other'])->default('user');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile');
            $table->string('address');
            $table->string('city')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('companyName');
            $table->string('companyLogo')->default('assets/img/noimage.jpg')->nullable();
            $table->string('websiteUrl')->nullable();
            $table->string('app_key')->unique();
            $table->string('app_secret')->nullable();
            $table->string('locktimeout')->default('10')->comment('System auto logout if no activity found.');
            $table->enum('status', ['1','0'])->default('1')->comment('1:Active, 0:Inactive');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
