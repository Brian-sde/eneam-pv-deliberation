<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pvs', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('session');
            $table->date('date_deliberation');
            $table->string('president_jury');
            $table->text('membres_jury');
            $table->string('fichier_path')->nullable();
            $table->string('statut')->default('brouillon'); // brouillon, valide, archive

            $table->foreignId('filiere_id')->constrained('filieres');
            $table->foreignId('annee_academique_id')->constrained('annee_academiques');
            $table->foreignId('niveau_id')->constrained('niveaux');
            $table->foreignId('semestre_id')->constrained('semestres');
            $table->foreignId('user_id')->constrained('users');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pvs');
    }
};