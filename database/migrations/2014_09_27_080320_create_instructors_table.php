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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('FKLoginId')->nullable()->references('id')->on('login');
            $table->string('firstname');
            $table->string('insertion')->nullable();
            $table->string('lastname');
            $table->integer('isActive')->default(true);
            // $table->softDeletes(); // Add soft delete column


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
