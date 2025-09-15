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
        if (!Schema::hasTable('report_target_produksi')) {
            Schema::create('report_target_produksi', function (Blueprint $table) {
                $table->id();
                $table->string('po_id');
                $table->string('po_date');
                $table->string('start_hour');
                $table->string('material_desc');
                $table->string('hasil');
                $table->string('target');
                $table->string('keterangan');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_target_produksi');
    }
};
