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
        Schema::create('absensi_opr_for_karu', function (Blueprint $table) {
            $table->id();
            $table->string('karu_id');
            $table->string('opr_id');
            $table->string('kode_group');
            $table->string('kode_area');
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
        Schema::dropIfExists('absensi_opr_for_karu');
    }
};
