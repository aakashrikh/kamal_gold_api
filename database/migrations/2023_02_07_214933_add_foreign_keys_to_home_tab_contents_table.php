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
        Schema::table('home_tab_contents', function (Blueprint $table) {
            $table->foreign(['home_tab_controller_id'], 'htc_id')->references(['id'])->on('home_tab_controllers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_tab_contents', function (Blueprint $table) {
            $table->dropForeign('htc_id');
        });
    }
};
