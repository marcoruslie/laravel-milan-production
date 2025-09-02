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
        Schema::create('qc_spraydryers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('kode_body');
            $table->string('jam_cek_1');
            $table->string('vs_rheology');
            $table->string('ds_rheology');
            $table->string('ka_rheology');
            $table->string('rs_rheology');
            $table->string('jam_cek_2');
            $table->string('tek_ppb_1');
            $table->string('tek_ppb_2');
            $table->string('t3');
            $table->string('jum_noz');
            $table->string('g_30');
            $table->string('g_40');
            $table->string('g_50');
            $table->string('g_60');
            $table->string('g_80');
            $table->string('g_120');
            $table->string('g_230');
            $table->string('g_230_more');
            $table->string('jumlah');
            $table->string('ka');
            $table->string('silo');
            $table->string('stock_powder');
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qc_spraydryers');
    }
};
