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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 50)->unique(); // Ex: "102458-22"
            $table->string('last_name');
            $table->string('first_name');
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();

            $table->index(['last_name', 'first_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
