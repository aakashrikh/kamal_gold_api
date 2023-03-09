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
        Schema::create('vendor_inventory_purchases', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('supplier_id')->index('supplier_id');
            $table->integer('po_no');
            $table->bigInteger('vendor_id');
            $table->date('purchase_date');
            $table->boolean('is_paid');
            $table->boolean('stock_added');
            $table->string('note', 150)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->double('igst');
            $table->double('cgst');
            $table->double('sgst');
            $table->double('total_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_inventory_purchases');
    }
};
