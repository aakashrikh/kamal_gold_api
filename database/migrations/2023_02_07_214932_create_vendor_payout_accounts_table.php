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
        Schema::create('vendor_payout_accounts', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vendor_id')->index('payout_vendor_id');
            $table->double('bank_account_no');
            $table->string('bank_ifsc', 50);
            $table->string('beneficiary_name', 50);
            $table->string('payout_account_id', 100);
            $table->string('payout_fund_id', 100);
            $table->string('payout_account_status', 100);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->string('business_email', 50);
            $table->string('business_name', 100);
            $table->string('business_type', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_payout_accounts');
    }
};
