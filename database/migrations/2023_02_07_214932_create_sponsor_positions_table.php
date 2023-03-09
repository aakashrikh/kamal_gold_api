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
        Schema::create('sponsor_positions', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('image');
            $table->string('seller_name');
            $table->string('category');
            $table->integer('sort_order');
            $table->string('expiry');
            $table->string('status');
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
        Schema::dropIfExists('sponsor_positions');
    }
};
