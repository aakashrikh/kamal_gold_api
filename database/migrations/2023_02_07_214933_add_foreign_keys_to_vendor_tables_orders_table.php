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
        Schema::table('vendor_tables_orders', function (Blueprint $table) {
            $table->foreign(['table_id'], 'Vendor_table_id')->references(['id'])->on('vendor_tables');
            $table->foreign(['order_id'], 'table_order')->references(['id'])->on('user_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_tables_orders', function (Blueprint $table) {
            $table->dropForeign('Vendor_table_id');
            $table->dropForeign('table_order');
        });
    }
};
