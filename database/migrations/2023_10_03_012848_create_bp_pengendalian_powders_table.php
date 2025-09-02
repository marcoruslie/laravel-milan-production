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
        Schema::create('bp_pengendalian_powders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('start_spray');
            $table->string('powder_masuk');
            $table->string('stop_spray');
            $table->string('dari_tanki');
            $table->string('ke_tanki');
            $table->string('reologi');
            $table->string('kapasitas');
            $table->string('granulasi');
            $table->string('indicator');
            $table->string('nozle_1');
            $table->string('nozle_2');
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
        Schema::dropIfExists('bp_pp_2s');
    }
};
