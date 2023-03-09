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
        Schema::create('partner_with_us', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 50);
            $table->string('contact', 50);
            $table->string('email', 50);
            $table->string('city', 100);
            $table->string('register_for', 50);
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_with_us');
    }
};
