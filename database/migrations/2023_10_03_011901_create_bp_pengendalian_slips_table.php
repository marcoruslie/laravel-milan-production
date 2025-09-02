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
        Schema::create('bp_pengendalian_slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('bm');
            $table->string('komposisi');
            $table->string('air_liter');
            $table->string('start');
            $table->string('finish');
            $table->string('sttp');
            $table->string('water_glass');
            $table->string('air');
            $table->string('jam_giling');
            $table->string('alumina');
            $table->string('setting_jam_giling');
            $table->string('total_jam_giling');
            $table->string('masuk_tanki_no');
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
        Schema::dropIfExists('bp_pp_1s');
    }
};
