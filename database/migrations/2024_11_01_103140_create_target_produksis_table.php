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
        Schema::create('target_produksis', function (Blueprint $table) {
            $table->id();
            $table->string('mesin_id');
            $table->unsignedBigInteger('target_pcs');
            $table->unsignedBigInteger('target_m2');
            $table->timestamp('begin_date')->nullable();
            $table->timestamp('end_date')->nullable();
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
        Schema::dropIfExists('target_produksis');
    }
};
