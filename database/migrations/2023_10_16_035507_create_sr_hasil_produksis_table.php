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
        Schema::create('sr_hasil_produksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('from');
            $table->string('no');
            $table->string('jumlah');
            $table->string('unloading');
            $table->string('a')->default('');
            $table->string('s')->default('');
            $table->string('m')->default('');
            $table->string('l')->default('');
            $table->string('ll')->default('');
            $table->string('xm')->default('');
            $table->string('xl')->default('');
            $table->string('b')->default('');
            $table->string('e')->default('');
            $table->string('g')->default('');
            $table->string('h')->default('');
            $table->string('f')->default('');
            $table->string('c')->default('');
            $table->string('q')->default('');
            $table->string('kw4')->default('');
            $table->string('jumlah_total');
            $table->string('karton');
            $table->string('kw4ket');
            $table->string('bs');
            $table->string('afal');
            $table->string('total');
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
        Schema::dropIfExists('sr_hasil_produksis');
    }
};
