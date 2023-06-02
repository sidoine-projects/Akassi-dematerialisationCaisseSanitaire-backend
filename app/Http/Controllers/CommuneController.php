<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communes = Commune::all();

        return response()->json([
            'success' => true,
            'data' => $communes,
            'message' => 'Liste des communes.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'departement_id' => 'required|exists:departements,id',
        ]);

        $commune = new Commune();
        $commune->nom = $request->input('nom');
        $commune->departement_id = $request->input('departement_id');

        // Enregistrez la commune dans la base de données
        $commune->save();

        return response()->json([
            'success' => true,
            'data' => $commune,
            'message' => 'La commune a été créée avec succès.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $commune = Commune::find($id);

        return response()->json([
            'success' => true,
            'data' => $commune,
            'message' => 'Détails de la commune récupérés avec succès.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $commune = Commune::find($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'departement_id' => 'required|integer',
            // Ajoutez d'autres règles de validation pour les autres champs si nécessaire
        ]);

        $commune->nom = $request->input('nom');
        $commune->departement_id = $request->input('departement_id');

        // Enregistrez les modifications de la commune dans la base de données
        $commune->save();

        return response()->json([
            'success' => true,
            'data' => $commune,
            'message' => 'La commune a été mise à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $commune = Commune::find($id);

        // Supprimez la commune de la base de données
        $commune->delete();

        return response()->json([
            'success' => true,
            'message' => 'La commune a été supprimée avec succès.'
        ]);
    }
}
