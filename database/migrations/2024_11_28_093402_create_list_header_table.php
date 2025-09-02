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
        Schema::create('list_header_po', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('po_id');
            $table->string('po_date');
            $table->string('material_desc');
            $table->string('status_qc');
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
        Schema::dropIfExists('list_header');
    }
};
