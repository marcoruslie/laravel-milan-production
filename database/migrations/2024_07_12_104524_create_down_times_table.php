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
        Schema::create('down_times', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('work_center');
            $table->string('start_date');
            $table->string('start_time');
            $table->string('respond_date');
            $table->string('respond_time');
            $table->string('finish_date');
            $table->string('finish_time');
            $table->string('total');
            $table->string('grund');
            $table->string('lngtxt');
            $table->string('cancel');
            $table->integer('status');
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
        Schema::dropIfExists('down_times');
    }
};
