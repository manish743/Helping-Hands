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
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('package_type')->default('Regular Subscription');
            $table->integer('subscription_duration');
            $table->integer('no_of_users');
            $table->integer('no_of_vacancy');
            $table->boolean('can_generate_link')->default(false);
            $table->boolean('can_ask_cim')->default(true);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('subscription_packages');
    }
};
