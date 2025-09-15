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
        Schema::table('sr_list_kualitas', function (Blueprint $table) {
            //
            if (Schema::hasColumn('sr_list_kualitas', 'kw')) {
                $table->dropColumn('kw');
            }
            if (Schema::hasColumn('sr_list_kualitas', 'jumlah')) {
                $table->dropColumn('jumlah');
            }
            $table->string('kw2')->nullable();
            $table->string('kw3')->nullable();
            $table->string('kw4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sr_list_kualitas', function (Blueprint $table) {
            //
        });
    }
};
