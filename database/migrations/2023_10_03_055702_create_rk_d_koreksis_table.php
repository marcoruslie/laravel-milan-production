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
        Schema::create('rk_d_koreksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rk_koreksi_id');
            $table->String('T1')->nullable();
            $table->String('T2')->nullable();
            $table->String('T3')->nullable();
            $table->String('T4')->nullable();
            $table->String('T5')->nullable();
            $table->String('T6')->nullable();
            $table->String('T7')->nullable();
            $table->String('T8')->nullable();
            $table->String('T9')->nullable();
            $table->foreign('rk_koreksi_id')
                ->references('id')
                ->on('rk_koreksi_tiles')
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
        Schema::dropIfExists('rk_d_koreksis');
    }
};
