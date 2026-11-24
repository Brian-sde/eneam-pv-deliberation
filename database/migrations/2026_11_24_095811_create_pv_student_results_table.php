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
        Schema::create('pv_student_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pv_id')->constrained('pvs')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->decimal('average', 4, 2)->nullable(); // Ex: 14.50
            $table->integer('credits_earned')->nullable(); // Ex: 30
            $table->enum('decision', ['admis', 'ajourne', 'rattrapage', 'exclu', 'compense']);
            $table->integer('rank')->nullable();
            $table->string('mention', 50)->nullable(); // Ex: "Passable", "Assez Bien", "Bien", "Très Bien"
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['pv_id', 'student_id']);
            $table->index('decision');
            $table->index('average');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pv_student_results');
    }
};
