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
        Schema::create('pvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->string('reference', 100)->unique(); // Ex: "PV-2024-IG-L2-S3-NORM"
            $table->enum('session', ['normale', 'rattrapage'])->default('normale');
            $table->date('deliberation_date');
            $table->string('jury_president');
            $table->json('jury_members')->nullable(); // Liste structurée des membres du jury
            $table->string('file_path')->nullable();   // Scan haute résolution (PDF ou image)
            $table->string('file_hash_sha256', 64)->nullable()->index(); // Scellement et intégrité cryptographique
            $table->enum('status', ['draft', 'validated', 'archived', 'rectified'])->default('draft');
            
            // Auto-référence pour l'historique des PV additifs / rectificatifs
            $table->foreignId('parent_pv_id')->nullable()->constrained('pvs')->nullOnDelete();
            $table->text('rectification_reason')->nullable();
            
            $table->text('observations')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();

            $table->index(['promotion_id', 'semester_id', 'session']);
            $table->index('deliberation_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pvs');
    }
};
