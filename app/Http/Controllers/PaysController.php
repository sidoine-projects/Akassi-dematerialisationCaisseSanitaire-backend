<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use Illuminate\Http\Request;

class PaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pays = Pays::all();
        return response()->json([
            'success' => true,
            'data' => $pays,
            'message' => 'Liste des pays.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            // Ajoutez d'autres règles de validation pour les autres champs si nécessaire
        ]);

        $pays = new Pays();
        $pays->name = $request->input('nom');

        // Enregistrez le pays dans la base de données
        $pays->save();

        return response()->json([
            'success' => true,
            'data' => $pays,
            'message' => 'Le pays a été créé avec succès.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pays = Pays::find($id);

        return response()->json([
            'success' => true,
            'data' => $pays,
            'message' => 'Détails du pays.'
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pays = Pays::find($id);

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            // Ajoutez ici les autres règles de validation pour les autres champs du modèle Pays
        ]);

        // Mettre à jour les propriétés du modèle Pays avec les données validées
        $pays->nom = $validatedData['nom'];
        // Mettez à jour ici les autres propriétés du modèle Pays avec les données validées

        // Enregistrer les modifications dans la base de données
        $pays->save();

        return response()->json([
            'success' => true,
            'data' => $pays,
            'message' => 'Pays mis à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pays = Pays::find($id);

        // Supprimer le pays de la base de données
        $pays->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pays supprimé avec succès.'
        ]);
    }
}