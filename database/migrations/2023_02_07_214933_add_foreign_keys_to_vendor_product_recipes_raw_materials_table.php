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
        Schema::table('vendor_product_recipes_raw_materials', function (Blueprint $table) {
            $table->foreign(['raw_product_id'], 'raw_product_id')->references(['id'])->on('vendor_inventory_products');
            $table->foreign(['product_id'], 'vendor_product_id')->references(['id'])->on('vendor_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_product_recipes_raw_materials', function (Blueprint $table) {
            $table->dropForeign('raw_product_id');
            $table->dropForeign('vendor_product_id');
        });
    }
};
