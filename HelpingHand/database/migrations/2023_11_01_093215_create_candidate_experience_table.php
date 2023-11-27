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
        Schema::create('candidate_experience', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_title');
            $table->string('job_tenure');
            $table->string('company_name');
            $table->text('responsibility');
            $table->text('achievement');
            $table->text('skills_developed')->nullable();
            $table->unsignedBigInteger('candidate_id');
            $table->tinyInteger('present_job');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_experience');
    }
};
