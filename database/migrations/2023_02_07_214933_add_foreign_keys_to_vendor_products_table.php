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
        Schema::table('vendor_products', function (Blueprint $table) {
            $table->foreign(['vendor_category_id'], 'vendor_category_id')->references(['id'])->on('vendor_categories');
            $table->foreign(['vendor_id'], 'vendor_id_pro')->references(['id'])->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_products', function (Blueprint $table) {
            $table->dropForeign('vendor_category_id');
            $table->dropForeign('vendor_id_pro');
        });
    }
};
