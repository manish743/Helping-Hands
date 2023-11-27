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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('org_name');
            $table->string('org_email')->unique();
            $table->string('owner_full_name')->nullable();
            $table->string('owner_email');
            $table->string('contact');
            $table->integer('no_vacaancy')->nullable();
            $table->unsignedBigInteger('subscription_package_id');
            $table->unsignedBigInteger('org_type_id');
            $table->text('org_description');
            $table->timestamp('expires_at')->nullable();
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
        Schema::dropIfExists('employee_details');
    }
};
