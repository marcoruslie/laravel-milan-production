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
            //
            $table->string('jenis_tile', 100)->after('kode_size');
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
