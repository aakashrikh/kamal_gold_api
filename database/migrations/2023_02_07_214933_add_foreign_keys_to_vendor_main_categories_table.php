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
        Schema::table('vendor_main_categories', function (Blueprint $table) {
            $table->foreign(['vendor_id'], 'category_vendor_id')->references(['id'])->on('vendors');
            $table->foreign(['category_id'], 'vendor_category')->references(['id'])->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_main_categories', function (Blueprint $table) {
            $table->dropForeign('category_vendor_id');
            $table->dropForeign('vendor_category');
        });
    }
};
