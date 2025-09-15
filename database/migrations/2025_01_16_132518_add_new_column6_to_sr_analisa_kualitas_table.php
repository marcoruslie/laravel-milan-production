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
        Schema::table('sr_analisa_kualitas', function (Blueprint $table) {
            if (!Schema::hasColumn('sr_analisa_kualitas', 'material_desc')) {
                $table->string('material_desc', 100)->after('size')->nullable();
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
        Schema::table('sr_analisa_kualitas', function (Blueprint $table) {
            //
        });
    }
};
