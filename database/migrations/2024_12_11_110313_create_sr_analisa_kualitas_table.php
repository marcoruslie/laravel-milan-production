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
        if (!Schema::hasTable('sr_analisa_kualitas')) {
            Schema::create('sr_analisa_kualitas', function (Blueprint $table) {
                $table->id();
                $table->string('order_id', 100);
                $table->string('kode_size', 100);
                $table->string('no_gl', 100);
                $table->string('no_car_gl', 100);
                $table->string('tgl_loading', 100);
                $table->string('jam_loading', 100);
                $table->string('no_kiln', 100);
                $table->string('no_car_kiln', 100);
                $table->string('tgl_bakar', 100);
                $table->string('jam_bakar', 100);
                $table->string('jenis_box', 100);
                $table->string('cara_sortir', 100);
                $table->string('kw1', 100);
                $table->string('kw2', 100);
                $table->string('kw3', 100);
                $table->string('kw4', 100);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sr_analisa_kualitas');
    }
};
