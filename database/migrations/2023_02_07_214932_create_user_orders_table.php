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
        Schema::create('user_orders', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('order_code', 50);
            $table->double('order_amount');
            $table->double('total_amount');
            $table->double('cgst')->default(0);
            $table->double('sgst')->default(0);
            $table->double('order_discount');
            $table->string('discount_type', 50)->nullable();
            $table->double('convenience_fee')->default(0);
            $table->double('user_wallet')->default(0);
            $table->string('order_status', 50);
            $table->timestamp('estimate_prepare_time')->useCurrentOnUpdate()->useCurrent();
            $table->string('order_for', 50);
            $table->string('order_comment', 150)->nullable();
            $table->bigInteger('user_id')->index('order_user');
            $table->bigInteger('vendor_id')->index('order_vendor');
            $table->bigInteger('staff_id')->default(0);
            $table->string('order_type', 150)->default('delivery');
            $table->string('channel', 100)->nullable()->default('website');
            $table->string('instruction', 250)->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->string('updated_at', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_orders');
    }
};
