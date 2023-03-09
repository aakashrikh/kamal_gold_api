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
        Schema::table('vendor_inventory_purchases', function (Blueprint $table) {
            $table->foreign(['supplier_id'], 'supplier_id')->references(['id'])->on('vendor_inventory_suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_inventory_purchases', function (Blueprint $table) {
            $table->dropForeign('supplier_id');
        });
    }
};
