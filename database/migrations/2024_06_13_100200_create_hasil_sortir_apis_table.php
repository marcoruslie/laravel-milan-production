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
        Schema::create('hasil_sortir_apis', function (Blueprint $table) {
            $table->id();
            $table->string('AUFNR');
            $table->string('MATNR');
            $table->string('WERKS');
            $table->string('LGORT');
            $table->string('BWART');
            $table->string('MENGE');
            $table->string('ERFMG');
            $table->string('ERFME');
            $table->string('MAKTX');
            $table->string('MBLNR');
            $table->string('MJAHR');
            $table->string('BUDAT');
            $table->string('WRHZET');
            $table->string('ARBPL');
            $table->string('MVGR4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_sortir_apis');
    }
};
