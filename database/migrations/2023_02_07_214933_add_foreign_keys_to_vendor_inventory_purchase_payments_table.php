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
        Schema::table('vendor_inventory_purchase_payments', function (Blueprint $table) {
            $table->foreign(['purchase_id'], 'purchase_id')->references(['id'])->on('vendor_inventory_purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_inventory_purchase_payments', function (Blueprint $table) {
            $table->dropForeign('purchase_id');
        });
    }
};
