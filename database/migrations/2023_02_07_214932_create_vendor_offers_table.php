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
        Schema::create('vendor_offers', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vendor_id')->index('vendor_id');
            $table->string('offer_code', 50);
            $table->text('offer_description')->nullable();
            $table->date('start_from');
            $table->string('offer_name');
            $table->string('discount_type', 45)->nullable();
            $table->double('offer_discount');
            $table->date('start_to')->nullable();
            $table->double('max_discount');
            $table->double('min_order_value');
            $table->integer('max_uses');
            $table->string('status', 45);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('show_customer');
            $table->integer('per_customer_limit');
            $table->double('total_uses');
            $table->double('total_sales_genrated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_offers');
    }
};
