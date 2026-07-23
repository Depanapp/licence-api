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
        Schema::create('licences', function (Blueprint $table) {

            $table->id();

            $table->foreignId('entreprise_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('cle')
                ->unique();

            $table->string('type')
                ->default('annuelle');

            $table->date('date_debut');

            $table->date('date_expiration');

            $table->enum('statut', [
                'active',
                'expiree',
                'bloquee'
            ])->default('active');

            $table->integer('nombre_utilisateurs')
                ->default(5);

            $table->integer('nombre_vehicules')
                ->default(100);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licences');
    }
};
