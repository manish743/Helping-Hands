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
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('org_id')->nullable();
            $table->integer('project_number');
            $table->string('vacant_position');
            $table->string('job_type')->default('Full Time');
            $table->string('type_of_position')->nullable();
            $table->string('department')->nullable();
            $table->tinyInteger('cim_candidate')->nullable();
            $table->string('stages')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('jobs');
    }
};
