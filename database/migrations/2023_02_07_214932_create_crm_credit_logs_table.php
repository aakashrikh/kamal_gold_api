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
        Schema::create('crm_credit_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vendor_id');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->double('credits');
            $table->string('credits_type', 50);
            $table->bigInteger('credit_txn_id');
            $table->bigInteger('compaign_id');
            $table->string('credit_status', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_credit_logs');
    }
};
