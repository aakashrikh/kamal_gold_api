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
        Schema::table('vendor_ratings', function (Blueprint $table) {
            $table->foreign(['vendor_id'], 'ratig')->references(['id'])->on('vendors');
            $table->foreign(['user_id'], 'user_r')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_ratings', function (Blueprint $table) {
            $table->dropForeign('ratig');
            $table->dropForeign('user_r');
        });
    }
};
