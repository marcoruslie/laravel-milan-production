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
            //$table->dropForeign(['id_header_po']);
            if (Schema::hasColumn('detail_qc_po', 'id_header_po')) {
                $table->dropColumn('id_header_po');
            }
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
