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
        Schema::create('user_refer_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('refer_id');
            $table->bigInteger('user_id')->default(0);
            $table->string('user_ip_address', 350);
            $table->string('user_device', 250);
            $table->string('user_os', 50);
            $table->string('refer_status', 50);
            $table->double('refer_amount');
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
        Schema::dropIfExists('user_refer_logs');
    }
};
