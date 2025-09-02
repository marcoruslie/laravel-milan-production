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
        Schema::create('gl_hasil_produksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('size');
            $table->string('jenis');
            $table->string('from');
            $table->string('no');
            $table->string('start');
            $table->string('stop');
            $table->string('menit');
            $table->string('jumlah');
            $table->boolean('is_confirm')->default(false);
            $table->foreign('shift_id')
                ->references('id')
                ->on('shifts')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('hasil_produksis');
    }
};
