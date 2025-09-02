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
        Schema::create('sr_list_kualitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sr_analisa_id')->references('id')->on('sr_analisa_kualitas')->onDelete('cascade');
            $table->string('cacat_id', 100)->references('id')->on('sr_jenis_cacat')->onDelete('cascade');
            $table->string('kw', 100);
            $table->string('jumlah', 100);
            $table->string('keterangan', 100);
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
        Schema::dropIfExists('sr_list_kualitas');
    }
};
