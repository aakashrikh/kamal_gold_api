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
        Schema::create('vendor_inventory_purchases_materials', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('purchase_id')->index('puchase_id material');
            $table->bigInteger('material_id')->index('material_id');
            $table->double('material_quantity');
            $table->string('material_unit', 50);
            $table->double('material_igst');
            $table->double('material_cgst');
            $table->double('material_sgst');
            $table->double('material_price');
            $table->double('material_total_price');
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
        Schema::dropIfExists('vendor_inventory_purchases_materials');
    }
};
