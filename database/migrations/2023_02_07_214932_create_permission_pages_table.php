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
        Schema::create('permission_pages', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('page_name')->nullable();
            $table->string('parent')->nullable();
            $table->string('status')->nullable();
            $table->string('icon')->nullable();
            $table->string('page_type', 45)->nullable();
            $table->string('category_name', 45)->nullable();
            $table->string('sidebar_icon', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_pages');
    }
};
