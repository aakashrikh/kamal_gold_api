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
        Schema::table('user_orders_txn_logs', function (Blueprint $table) {
            $table->foreign(['order_id'], 'order_id')->references(['id'])->on('user_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_orders_txn_logs', function (Blueprint $table) {
            $table->dropForeign('order_id');
        });
    }
};
