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
            $table->unsignedBigInteger('role_id'); // Ajoutez la colonne pour la clé étrangère

            $table->foreign('role_id')->references('id')->on('roles'); // Spécifiez la clé étrangère


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign(['role_id']); // Supprimez la contrainte de clé étrangère si nécessaire
            $table->dropColumn('role_id'); // Supprimez la colonne de clé étrangère si nécessaire
        });
    }
};
