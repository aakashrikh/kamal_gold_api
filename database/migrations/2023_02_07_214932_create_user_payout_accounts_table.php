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
        Schema::create('user_payout_accounts', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('account_id', 100);
            $table->string('account_status', 150);
            $table->string('account_merchant', 150);
            $table->bigInteger('user_id')->index('payout_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_payout_accounts');
    }
};
