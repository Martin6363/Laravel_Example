<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('email')->unique();
            $table->string('country', 100);
            $table->string('city', 100);
            $table->string('address', 100);
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('super_visor_id');
            $table->date('removed')->nullable();

            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('super_visor_id')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
