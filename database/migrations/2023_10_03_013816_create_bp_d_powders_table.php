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
        Schema::create('bp_d_powders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengendalian_id');
            $table->string('t1');
            $table->string('t3');
            $table->string('silo');
            $table->string('kadar_air');
            $table->string('ppb');
            $table->string('vc');
            $table->string('mf');
            $table->string('af');
            $table->foreign('pengendalian_id')
                ->references('id')
                ->on('bp_pengendalian_powders')
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
        Schema::dropIfExists('bp_d_powders');
    }
};
