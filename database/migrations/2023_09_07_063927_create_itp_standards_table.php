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
        Schema::create('itp_standards', function (Blueprint $table) {
            $table->id();
            $table->string('mesin');
            $table->string('form');
            $table->string('field');
            $table->string('var1')->default('-');
            $table->string('var2')->default('-');
            $table->string('var3')->default('-');
            $table->string('var4')->default('-');
            $table->string('var5')->default('-');
            $table->string('valfr');
            $table->string('valto');
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
        Schema::dropIfExists('itp_standards');
    }
};
