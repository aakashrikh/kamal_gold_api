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
        Schema::create('home_tab_controllers', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('tab_title', 150);
            $table->text('more_link')->nullable();
            $table->integer('sort_by');
            $table->string('type', 45);
            $table->string('status', 50)->default('active');
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
        Schema::dropIfExists('home_tab_controllers');
    }
};
