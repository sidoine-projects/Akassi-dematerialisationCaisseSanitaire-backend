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
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->string('nom');
            $table->string('prenom');
            $table->integer('age');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('profession')->nullable();
            $table->string('sexe');
            $table->string('urgencecontact');
            $table->string('situationmatrimoniale')->nullable();
            $table->unsignedBigInteger('pays_id');
            $table->unsignedBigInteger('departement_id');
            $table->unsignedBigInteger('commune_id');
            $table->unsignedBigInteger('arrondissement_id');
            $table->unsignedBigInteger('quartier_id');
            $table->text('autre')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pays_id')->references('id')->on('pays');
            $table->foreign('departement_id')->references('id')->on('departements');
            $table->foreign('commune_id')->references('id')->on('communes');
            $table->foreign('arrondissement_id')->references('id')->on('arrondissements');
            $table->foreign('quartier_id')->references('id')->on('quartiers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
