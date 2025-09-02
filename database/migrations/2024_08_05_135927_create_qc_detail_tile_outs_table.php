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
        Schema::create('qc_detail_tile_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('h_tile_out_id');
            $table->string('val1');
            $table->string('val2');
            $table->string('val3');
            $table->string('val4');
            $table->string('val5');
            $table->string('ukuran1');
            $table->string('ukuran2');
            $table->string('tebal');
            $table->string('dial');
            $table->string('beberan');
            $table->string('visual');
            $table->foreign('h_tile_out_id')
                ->references('id')
                ->on('qc_pengecekan_tile_outs')
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
        Schema::dropIfExists('qc_detail_tile_outs');
    }
};
