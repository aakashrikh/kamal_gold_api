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
        Schema::create('vendor_inventory_products', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('inventory_product_name', 150);
            $table->bigInteger('vendor_id');
            $table->bigInteger('inventory_category_id');
            $table->string('model', 150)->nullable();
            $table->string('purchase_unit', 150);
            $table->string('purchase_sub_unit', 20);
            $table->double('purchase_subunit_quantity');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('product_status', 100);
            $table->double('current_stock')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_inventory_products');
    }
};
