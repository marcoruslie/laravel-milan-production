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
        Schema::table('target_saps', function (Blueprint $table) {
            $table->unsignedBigInteger('std_min_1_per_24hour')->nullable();
            $table->stunsignedBigIntegerring('std_plus_1_per_24hour')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('target_saps', function (Blueprint $table) {
            //
        });
    }
};
