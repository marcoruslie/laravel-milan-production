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
        Schema::table('sr_analisa_kualitas', function (Blueprint $table) {
            $table->string('no_ph', 100)->after('kode_size')->nullable();
            $table->string('no_hd', 100)->after('no_ph')->nullable();
            $table->string('jenis_mesin_cutting', 100)->nullable();
            $table->string('no_mesin_cutting', 100)->nullable();
            $table->string('input_cutting', 100)->nullable();
            $table->string('no_car_gl', 100)->nullable()->change();
            $table->string('no_car_kiln', 100)->nullable()->change();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sr_analisa_kualitas', function (Blueprint $table) {
            //
        });
    }
};
