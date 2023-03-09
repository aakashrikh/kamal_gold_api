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
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->unique('contact');
            $table->text('description')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('shop_latitude')->nullable();
            $table->string('shop_longitude')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('status')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('city')->nullable();
            $table->string('shop_no', 500)->nullable();
            $table->integer('flat_deal_first_time')->default(0);
            $table->integer('flat_deal_all_time')->default(0);
            $table->double('whatsapp')->nullable();
            $table->string('website', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('state', 250)->nullable();
            $table->string('area')->nullable();
            $table->string('category_type', 50)->default('service');
            $table->string('pincode')->nullable();
            $table->string('is_prime', 10)->default('no');
            $table->string('vendor_code', 10)->nullable()->unique('vendor_code');
            $table->boolean('payment_accept')->nullable()->default(false);
            $table->float('current_rating', 10, 0)->default(0);
            $table->string('gstin', 50)->nullable();
            $table->double('gst_percentage')->default(0);
            $table->string('gst_type', 150)->nullable();
            $table->double('service_charge')->default(0);
            $table->double('wallet')->default(0);
            $table->double('weazy_credits');
            $table->timestamps();
            $table->string('vendor_uu_id', 150);
            $table->boolean('kot_time_status')->default(false);
            $table->boolean('live_inventory');
            $table->boolean('shop_open')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
