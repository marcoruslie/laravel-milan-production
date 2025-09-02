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
        Schema::create('bp_rekap_hasil_slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('komposisi_body');
            $table->string('tab');
            $table->string('a2');
            $table->string('a3');
            $table->string('a4');
            $table->string('a6');
            $table->string('a7');
            $table->string('a8');
            $table->string('a9');
            $table->string('a10');
            $table->string('a11');
            $table->string('a12');
            $table->string('b1');
            $table->string('b2');
            $table->string('b3');
            $table->string('b4');
            $table->string('b5');
            $table->string('b6');
            $table->string('b7');
            $table->boolean('is_confirm')->default(false);
            $table->foreign('shift_id')
                ->references('id')
                ->on('shifts')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('kode_material')->default(0);
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
        Schema::dropIfExists('rekap_hasil_slips');
    }
};
