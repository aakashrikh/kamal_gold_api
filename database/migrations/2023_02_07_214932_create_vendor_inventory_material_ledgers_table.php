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
        Schema::create('vendor_inventory_material_ledgers', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('product_id');
            $table->string('comment', 50);
            $table->double('quantity');
            $table->string('quantity_unit', 50);
            $table->string('record_type', 100);
            $table->bigInteger('relation_id');
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
        Schema::dropIfExists('vendor_inventory_material_ledgers');
    }
};
