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
        Schema::create('ph_d_dimensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('h_dimensi_id');
            $table->String('D1')->nullable();
            $table->String('D2')->nullable();
            $table->String('D3')->nullable();
            $table->String('D4')->nullable();
            $table->String('D5')->nullable();
            $table->String('D6')->nullable();
            $table->String('D7')->nullable();
            $table->String('D8')->nullable();
            $table->String('center')->nullable();
            $table->foreign('h_dimensi_id')
                ->references('id')
                ->on('ph_dimensis')
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
        Schema::dropIfExists('d_dimensis');
    }
};
