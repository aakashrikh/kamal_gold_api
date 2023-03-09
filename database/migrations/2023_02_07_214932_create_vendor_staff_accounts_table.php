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
        Schema::create('vendor_staff_accounts', function (Blueprint $table) {
            $table->bigInteger('staff_id', true);
            $table->string('staff_name', 50);
            $table->string('staff_contact', 15);
            $table->string('staff_role', 50);
            $table->string('staff_account_status', 50);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('id');
            $table->string('password', 200);
            $table->rememberToken()->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_staff_accounts');
    }
};
