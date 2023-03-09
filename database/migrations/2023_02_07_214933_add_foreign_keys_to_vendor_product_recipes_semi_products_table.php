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
        Schema::table('vendor_product_recipes_semi_products', function (Blueprint $table) {
            $table->foreign(['product_id'], 'product_id')->references(['id'])->on('vendor_products');
            $table->foreign(['semi_product_id'], 'semi_dishes_id')->references(['id'])->on('vendor_inventory_semi_dishes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_product_recipes_semi_products', function (Blueprint $table) {
            $table->dropForeign('product_id');
            $table->dropForeign('semi_dishes_id');
        });
    }
};
