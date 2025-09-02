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
        Schema::create('update_logs', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('shift');
            $table->string('user');
            $table->string('param1');
            $table->string('param2');
            $table->string('param3');
            $table->string('param4');
            $table->string('value_before');
            $table->string('value_after');
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
        Schema::dropIfExists('update_logs');
    }
};
