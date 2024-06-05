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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('insertion')->nullable();
            $table->string('lastname');
            $table->string('phone');
            $table->string('address');
            $table->string('huisnumber');
            $table->string('postcode');
            $table->string('city');
            $table->date('dateOfBirth');
            $table->string('bankaccountnumber');
            $table->integer('lesson_hours')->default(0);
            $table->foreignId('instructor_id')->nullable()->references('id')->on('instructors');
            $table->foreignId('FKLoginId')->nullable()->references('id')->on('login');
            $table->integer('isActive')->default(true);
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
