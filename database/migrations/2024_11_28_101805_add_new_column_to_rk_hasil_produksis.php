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
        Schema::table('rk_hasil_produksis', function (Blueprint $table) {
            if (!Schema::hasColumn('rk_hasil_produksis', 'kode_material')) {
                $table->unsignedBigInteger('kode_material')->default(0)->after('user_id');
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
        Schema::table('rk_hasil_produksis', function (Blueprint $table) {
            //
        });
    }
};
