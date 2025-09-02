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
        Schema::create('ph_temp_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('mesin');
            $table->string('lane');
            $table->string('size');
            $table->string('jenis');
            $table->string('sap_11');
            $table->string('sap_12');
            $table->string('sap_13');
            $table->string('sap_14');
            $table->string('sap_21');
            $table->string('sap_22');
            $table->string('sap_23');
            $table->string('sap_24');
            $table->string('sap_31');
            $table->string('sap_32');
            $table->string('sap_33');
            $table->string('sap_34');
            $table->string('sap_41');
            $table->string('sap_42');
            $table->string('sap_43');
            $table->string('sap_44');
            $table->string('sap_51');
            $table->string('sap_52');
            $table->string('sap_53');
            $table->string('sap_54');
            $table->boolean('is_confirm')->default(false);
            $table->foreign('shift_id')
                ->references('id')
                ->on('shifts')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ph_temp_outs');
    }
};
