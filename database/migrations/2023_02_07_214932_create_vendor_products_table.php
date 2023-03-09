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
        Schema::create('vendor_products', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vendor_id')->index('vendor_id_pro');
            $table->bigInteger('vendor_category_id')->index('vendor_category_id');
            $table->string('product_name');
            $table->text('product_img');
            $table->string('market_price')->nullable();
            $table->string('our_price');
            $table->double('tax');
            $table->string('description');
            $table->integer('is_veg')->nullable()->default(1);
            $table->string('status');
            $table->timestamps();
            $table->string('type', 50);
            $table->string('qr_enable', 20)->nullable()->default('active');
            $table->integer('max_product_addons')->default(0);
            $table->integer('max_free_product_addons')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_products');
    }
};
