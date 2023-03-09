<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact');
            $table->string('password');
            $table->string('dob')->nullable()->default('02/02/1996');
            $table->date('anniversary')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('gender', 45)->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('email_verified_at', 50)->nullable();
            $table->string('location_lati')->nullable();
            $table->string('location_long')->nullable();
            $table->string('status')->nullable();
            $table->double('wallet')->default(0);
            $table->string('upi_id', 150)->nullable();
            $table->string('share_code', 56)->nullable();
            $table->string('notification')->nullable();
            $table->timestamps();
            $table->string('user_uu_id', 150)->nullable();
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
};
