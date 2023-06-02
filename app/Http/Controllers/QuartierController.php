<?php

namespace App\Http\Controllers;

use App\Models\Quartier;
use Illuminate\Http\Request;

class QuartierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quartiers = Quartier::all();

        return response()->json([
            'success' => true,
            'data' => $quartiers,
            'message' => 'Liste des quartiers récupérée avec succès.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'arrondissement_id' => 'required|exists:arrondissements,id'
        ]);

        $quartier = new Quartier();
        $quartier->nom = $request->input('nom');
        $quartier->arrondissement_id = $request->input('arrondissement_id');

        // Enregistrez le quartier dans la base de données
        $quartier->save();

        return response()->json([
            'success' => true,
            'data' => $quartier,
            'message' => 'Le quartier a été créé avec succès.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $quartier = Quartier::find($id);

        return response()->json([
            'success' => true,
            'data' => $quartier,
            'message' => 'Détails du quartier récupérés avec succès.'
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'arrondissement_id' => 'required|exists:arrondissements,id',
            // Ajoutez d'autres règles de validation pour les autres champs si nécessaire
        ]);

        $quartier = Quartier::findOrFail($id);
        $quartier->nom = $request->input('nom');
        $quartier->arrondissement_id = $request->input('arrondissement_id');

        // Enregistrez les modifications dans la base de données
        $quartier->save();

        return response()->json([
            'success' => true,
            'data' => $quartier,
            'message' => 'Le quartier a été mis à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $quartier = Quartier::find($id);

        // Supprimez le quartier de la base de données
        $quartier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Le quartier a été supprimé avec succès.'
        ]);
    }
}
