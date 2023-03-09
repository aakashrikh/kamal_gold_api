<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTxnMethodInCrmTxnLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_txn_logs', function (Blueprint $table) {
            $table->renameColumn('txn_method', 'subscription');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crm_txn_logs', function (Blueprint $table) {
            $table->renameColumn('subscription', 'txn_method');
        });
    }
}
