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
        Schema::create('employee_detail_specialization', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_detail_id');
            $table->unsignedBigInteger('specialization_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_detail_specialization');
    }
};
