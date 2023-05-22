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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('prenom');
            $table->string('nom_utilisateur');
            $table->string('adresse');
            $table->string('role');
            $table->string('telephone');
            $table->string('sexe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('prenom');
            $table->dropColumn('nom_utilisateur');
            $table->dropColumn('adresse');
            $table->dropColumn('role');
            $table->dropColumn('telephone');
            $table->dropColumn('sexe');
        });
    }
};