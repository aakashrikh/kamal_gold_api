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
        Schema::create('vendor_inventory_purchase_payments', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('purchase_id')->index('purchase_id');
            $table->double('txn_amount');
            $table->string('txn_method', 50);
            $table->string('txn_notes', 50)->nullable();
            $table->string('txn_narration', 50)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('txn_type', 50);
            $table->string('txn_status', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_inventory_purchase_payments');
    }
};
