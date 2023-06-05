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
        Schema::create('assurances', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('montant', 8, 2);
            $table->decimal('pourcentage', 5, 2);
            $table->unsignedBigInteger('compagnie_d_assurance_id');
            $table->foreign('compagnie_d_assurance_id')->references('id')->on('compagnies_d_assurance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assurances');
    }
};
