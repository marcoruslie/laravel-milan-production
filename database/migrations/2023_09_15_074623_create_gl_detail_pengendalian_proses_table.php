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
        Schema::create('detail_pengendalian_proses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gl_pengendalian_proses_id');
            $table->string('viscositas')->nullable();
            $table->string('densitas')->nullable();
            $table->string('berat')->nullable();
            $table->foreign('gl_pengendalian_proses_id')
                ->references('id')
                ->on('gl_pengendalian_proses')
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
        Schema::dropIfExists('gl_detail_pengendalian_proses');
    }
};
