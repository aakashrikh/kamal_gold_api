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
        Schema::create('user_orders_txn_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('order_id')->index('order_id');
            $table->string('payment_txn_id', 150);
            $table->double('txn_amount');
            $table->string('txn_method', 100);
            $table->string('txn_status', 50);
            $table->string('txn_channel', 50)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_orders_txn_logs');
    }
};
