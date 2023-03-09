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
        Schema::create('permission_user_pages', function (Blueprint $table) {
            $table->integer('page_id');
            $table->integer('employee_id');
            $table->string('view')->nullable();
            $table->string('add')->nullable();
            $table->string('edit')->nullable();
            $table->string('delete')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user_pages');
    }
};
