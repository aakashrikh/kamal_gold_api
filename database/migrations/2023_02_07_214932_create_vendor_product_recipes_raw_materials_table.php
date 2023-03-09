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
        Schema::create('vendor_product_recipes_raw_materials', function (Blueprint $table) {
            $table->bigInteger('product_id')->index('vendor_product_id');
            $table->bigInteger('product_variant_id');
            $table->bigInteger('raw_product_id')->index('raw_product_id');
            $table->double('raw_product_quantity');
            $table->string('raw_product_unit', 50);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_product_recipes_raw_materials');
    }
};
