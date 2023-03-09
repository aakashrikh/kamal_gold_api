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
        Schema::table('user_order_product_addons', function (Blueprint $table) {
            $table->foreign(['u_o_product_id'], 'user_addon')->references(['id'])->on('user_order_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_order_product_addons', function (Blueprint $table) {
            $table->dropForeign('user_addon');
        });
    }
};
