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
        Schema::create('vendor_inventory_semi_dishes', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vendor_id')->index('dish_vendor_id');
            $table->string('dish_name', 100);
            $table->double('dish_current_stock')->default(0);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('recipe_quantity', 100)->default('0');
            $table->string('dish_expiry', 20);
            $table->double('production_quantity_estimate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_inventory_semi_dishes');
    }
};
