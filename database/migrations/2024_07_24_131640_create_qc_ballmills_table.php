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
        Schema::create('qc_ballmills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('size');
            $table->string('jenis');
            $table->string('kode_body');
            $table->string('no_bm');
            $table->string('setting_jam');
            $table->string('start_milling');
            $table->string('stop_milling');
            $table->string('sttp_def');
            $table->string('wg_def');
            $table->string('air');
            $table->string('tgl_cek');
            $table->string('jam_cek');
            $table->string('vs_rhology');
            $table->string('ds_rhology');
            $table->string('ka_rhology');
            $table->string('rs_rhology');
            $table->string('sttp_koreksi');
            $table->string('wg_koreksi');
            $table->string('air_koreksi');
            $table->string('jamling_koreksi');
            $table->string('jam_tap');
            $table->string('total_miling');
            $table->string('tangki_tap');
            $table->string('ruang_bm');
            $table->string('ruang_slip');
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
        Schema::dropIfExists('qc_ballmills');
    }
};
