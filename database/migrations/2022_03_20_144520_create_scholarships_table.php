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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('major')->nullable();
            $table->string('country_id')->nullable();
            $table->string('target')->nullable();
            $table->integer('duration')->nullable();
            $table->string('conditions')->nullable();
            $table->string('requirements')->nullable();
            $table->string('type')->nullable();
            $table->integer('university_id')->nullable();
            $table->string('charity_name')->nullable();
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
        Schema::dropIfExists('scholarships');
    }
};
