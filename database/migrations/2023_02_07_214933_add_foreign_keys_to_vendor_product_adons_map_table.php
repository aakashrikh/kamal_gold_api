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
        Schema::table('vendor_product_adons_map', function (Blueprint $table) {
            $table->foreign(['product_id'], 'constr')->references(['id'])->on('vendor_products');
            $table->foreign(['addon_id'], 'pp_id')->references(['id'])->on('vendor_products_addons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_product_adons_map', function (Blueprint $table) {
            $table->dropForeign('constr');
            $table->dropForeign('pp_id');
        });
    }
};
