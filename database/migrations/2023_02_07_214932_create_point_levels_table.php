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
        Schema::create('point_levels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->float('review_point', 10, 0);
            $table->integer('review_count');
            $table->float('feed_points', 10, 0);
            $table->integer('feed_counts');
            $table->integer('max_point_per_day');
            $table->integer('bank_transfer_limit');
            $table->integer('txn_charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_levels');
    }
};
