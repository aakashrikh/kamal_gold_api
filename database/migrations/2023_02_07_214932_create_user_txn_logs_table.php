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
        Schema::create('user_txn_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('comment', 250);
            $table->integer('user_id');
            $table->string('txn_id', 250);
            $table->double('txn_amount');
            $table->string('txn_status', 20);
            $table->string('txn_type', 50);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_txn_logs');
    }
};
