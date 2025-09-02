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
        Schema::create('rk_pengendalian_proses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('size');
            $table->string('jenis');
            $table->string('fan_vacum');
            $table->string('fan_temp');
            $table->string('gas_preasure');
            $table->string('h28');
            $table->string('h27');
            $table->string('h1');
            $table->string('h2');
            $table->string('h3');
            $table->string('f4');
            $table->string('h5');
            $table->string('f6');
            $table->string('f6_setting');
            $table->string('h7');
            $table->string('f8');
            $table->string('a9');
            $table->string('a9_setting');
            $table->string('a10');
            $table->string('a10_Setting');
            $table->string('a11');
            $table->string('a11_setting');
            $table->string('a12');
            $table->string('a12_setting');
            $table->string('a13');
            $table->string('a13_setting');
            $table->string('a14');
            $table->string('a14_setting');
            $table->string('a15');
            $table->string('a15_setting');
            $table->string('a16');
            $table->string('a16_setting');
            $table->string('a17');
            $table->string('a17_setting');
            $table->string('a18');
            $table->string('a18_setting');
            $table->string('a19');
            $table->string('a19_setting');
            $table->string('a20');
            $table->string('a20_setting');
            $table->string('a21');
            $table->string('a21_setting');
            $table->string('a22');
            $table->string('a22_setting');
            $table->string('a23');
            $table->string('a24');
            $table->string('f25');
            $table->string('f26');
            $table->string('f26_setting');
            $table->string('comb_preasure');
            $table->string('comb_temp');
            $table->string('zero_point');
            $table->string('hot_air_fan');
            $table->string('speedy_preasure');
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
        Schema::dropIfExists('rk_pengendalian_proses');
    }
};
