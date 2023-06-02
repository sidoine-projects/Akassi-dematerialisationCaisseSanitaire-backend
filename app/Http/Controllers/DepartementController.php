<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departements = Departement::all();

        return response()->json([
            'success' => true,
            'data' => $departements,
            'message' => 'Liste des départements.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'pays_id' => 'required|exists:pays,id',
            // Ajoutez d'autres règles de validation pour les autres champs si nécessaire
        ]);

        $departement = new Departement();
        $departement->nom = $request->input('nom');
        $departement->pays_id = $request->input('pays_id');

        // Enregistrez le département dans la base de données
        $departement->save();

        return response()->json([
            'success' => true,
            'data' => $departement,
            'message' => 'Le département a été créé avec succès.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $departement = Departement::find($id);

        return response()->json([
            'success' => true,
            'data' => $departement,
            'message' => 'Informations sur le département récupérées avec succès.'
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'pays_id' => 'required|exists:pays,id',
            // Ajoutez d'autres règles de validation pour les autres champs si nécessaire
        ]);

        $departement = Departement::find($id);
        $departement->nom = $request->input('nom');

        // Mettez à jour les autres champs du département si nécessaire

        // Enregistrez les modifications dans la base de données
        $departement->save();

        return response()->json([
            'success' => true,
            'data' => $departement,
            'message' => 'Le département a été mis à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $departement = Departement::find($id);

        // Supprimez le département de la base de données
        $departement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Le département a été supprimé avec succès.'
        ]);
    }
}