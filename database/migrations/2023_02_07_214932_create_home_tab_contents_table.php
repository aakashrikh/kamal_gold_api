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
        Schema::create('home_tab_contents', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('home_tab_controller_id')->index('htc_id');
            $table->string('htc_title', 150);
            $table->string('image', 45);
            $table->text('image_link');
            $table->text('target_src')->nullable();
            $table->string('status', 150)->default('active');
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
        Schema::dropIfExists('home_tab_contents');
    }
};
