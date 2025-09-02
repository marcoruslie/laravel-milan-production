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
        Schema::create('bp_rekap_hasil_powders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin_id');
            $table->string('lane');
            $table->string('stok1');
            $table->string('stok2');
            $table->string('stok3');
            $table->string('stok4');
            $table->string('stok5');
            $table->string('stok6');
            $table->string('stok7');
            $table->string('stok8');
            $table->string('stok9');
            $table->string('stok10');
            $table->string('stok11');
            $table->string('stok12');
            $table->string('stok13');
            $table->string('stok14');
            $table->string('stok15');
            $table->string('stok16');
            $table->string('stok17');
            $table->string('stok18');
            $table->string('stok19');
            $table->string('stok20');
            $table->string('total_powder');
            $table->string('atm40');
            $table->string('kapasitas40');
            $table->string('atm90');
            $table->string('kapasitas90');
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
        Schema::dropIfExists('rekap_hasil_powders');
    }
};
