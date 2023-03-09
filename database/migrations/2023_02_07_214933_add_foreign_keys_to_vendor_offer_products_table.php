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
        Schema::table('vendor_offer_products', function (Blueprint $table) {
            $table->foreign(['offer_id'], 'offer_id')->references(['id'])->on('vendor_offers');
            $table->foreign(['product_id'], 'vendor_product')->references(['id'])->on('vendor_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_offer_products', function (Blueprint $table) {
            $table->dropForeign('offer_id');
            $table->dropForeign('vendor_product');
        });
    }
};
