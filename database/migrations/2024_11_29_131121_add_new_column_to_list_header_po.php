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
        Schema::table('list_header_po', function (Blueprint $table) {
            if (!Schema::hasColumn('list_header_po', 'user_id')) {
                $table->string('user_id')->nullable();
            }
            if (!Schema::hasColumn('list_header_po', 'approval_at')) {
                $table->string('approval_at')->nullable();
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
        Schema::table('list_header_po', function (Blueprint $table) {
            //
        });
    }
};
