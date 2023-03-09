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
        Schema::create('vendor_inventory_semi_dishes_materials', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('material_id');
            $table->bigInteger('dish_id');
            $table->double('material_quantity');
            $table->string('material_unit', 150);
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
        Schema::dropIfExists('vendor_inventory_semi_dishes_materials');
    }
};
