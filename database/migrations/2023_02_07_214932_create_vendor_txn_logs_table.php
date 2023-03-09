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
        Schema::create('vendor_txn_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->double('txn_amount');
            $table->text('txn_id');
            $table->string('txn_type', 50);
            $table->string('txn_status', 100);
            $table->text('txn_comment');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->bigInteger('vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_txn_logs');
    }
};
