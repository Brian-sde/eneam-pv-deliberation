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
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete();
            $table->string('code', 10); // Ex: "S1", "S2", ..., "S6"
            $table->string('name');     // Ex: "Semestre 1"
            $table->integer('order')->default(1);
            $table->timestamps();

            $table->unique(['level_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
