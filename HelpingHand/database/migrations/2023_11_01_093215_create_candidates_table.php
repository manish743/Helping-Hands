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
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact');
            $table->string('email');
            $table->unsignedBigInteger('current_salary')->nullable();
            $table->unsignedBigInteger('expected_salary')->nullable();
            $table->enum('job_type', ['Contractual-Fulltime', 'Permanent-Fulltime', 'Freelance', 'Part-Time']);
            $table->string('cv')->nullable();
            $table->text('summary')->nullable();
            $table->string('category')->nullable();
            $table->tinyInteger('is_screened')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->tinyInteger('available')->default(1);
            $table->text('speciality')->nullable();
            $table->text('interest')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
};
