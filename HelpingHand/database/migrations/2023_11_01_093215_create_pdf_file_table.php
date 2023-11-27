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
        Schema::create('pdf_file', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name');
            $table->string('path');
            $table->string('pdffilable_type');
            $table->unsignedBigInteger('pdffilable_id');
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
        Schema::dropIfExists('pdf_file');
    }
};
