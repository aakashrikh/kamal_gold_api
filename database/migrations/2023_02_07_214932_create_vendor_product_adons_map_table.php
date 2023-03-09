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
        Schema::create('vendor_product_adons_map', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('addon_id')->index('pp_id');
            $table->bigInteger('product_id')->index('constr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_product_adons_map');
    }
};
