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
        Schema::create('detail_qc_po', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_header_po')->references('po_id')->on('list_header_po')->onDelete('cascade');
            $table->string('nip_user')->references('nip')->on('users')->onDelete('cascade');
            $table->string('keterangan');
            $table->string('status');
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
        Schema::dropIfExists('detail_qc_po');
    }
};
