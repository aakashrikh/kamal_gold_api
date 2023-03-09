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
        Schema::create('vendor_inventory_suppliers', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('supplier_name', 500);
            $table->string('supplier_gstin', 20)->nullable();
            $table->string('supplier_contact', 20)->nullable();
            $table->string('supplier_address', 150)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('vendor_id')->index('supplier_vendor_id');
            $table->string('supplier_email', 70)->nullable();
            $table->string('suplier_status', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_inventory_suppliers');
    }
};
