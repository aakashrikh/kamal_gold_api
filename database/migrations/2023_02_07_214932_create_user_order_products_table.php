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
        Schema::create('user_order_products', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('order_id');
            $table->bigInteger('product_id');
            $table->double('product_price');
            $table->bigInteger('variant_id');
            $table->integer('product_quantity');
            $table->string('order_product_status', 100)->nullable()->default('pending');
            $table->bigInteger('kot')->default(0);
            $table->string('kot_status', 50)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_order_products');
    }
};
