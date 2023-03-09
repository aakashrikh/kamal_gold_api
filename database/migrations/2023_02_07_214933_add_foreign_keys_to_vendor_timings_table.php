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
        Schema::table('vendor_timings', function (Blueprint $table) {
            $table->foreign(['vendor_id'], 'timing_vendor_id')->references(['id'])->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_timings', function (Blueprint $table) {
            $table->dropForeign('timing_vendor_id');
        });
    }
};
