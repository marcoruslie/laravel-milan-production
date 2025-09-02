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
        Schema::create('gl_pengendalian_proses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('size');
            $table->string('jenis');
            $table->string('jenis_aplikasi');
            $table->string('engobe')->default('-');
            $table->string('engobe_visco')->default('-');
            $table->string('engobe_densi')->default('-');
            $table->string('engobe_berat')->default('-');
            $table->string('glaze')->default('-');
            $table->string('glaze_visco')->default('-');
            $table->string('glaze_densi')->default('-');
            $table->string('glaze_berat')->default('-');
            $table->string('pasta')->default('-');
            $table->string('pasta_visco')->default('-');
            $table->string('pasta_densi')->default('-');
            $table->string('temp_body');
            $table->string('set_pemukul');
            $table->string('sikat');
            $table->string('saringan');
            $table->boolean('is_confirm')->default(false);
            $table->foreign('shift_id')
                ->references('id')
                ->on('shifts')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gl_pengendalian_proses');
    }
};
