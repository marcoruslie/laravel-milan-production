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
        Schema::table('detail_qc_po', function (Blueprint $table) {
            if (Schema::hasColumn('detail_qc_po', 'nip')) {
                $table->dropColumn('nip');
            }
            $table->string('nip_user')->references('nip')->on('users')->onDelete('cascade');
            if (Schema::hasColumn('detail_qc_po', 'id_header_po')) {
                $table->dropColumn('id_header_po');
            }
            $table->foreignId('id_header_po')->references('po_id')->on('list_header_po')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
