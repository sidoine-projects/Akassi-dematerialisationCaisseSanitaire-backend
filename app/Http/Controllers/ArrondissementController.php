<?php

namespace App\Http\Controllers;

use App\Models\Arrondissement;
use Illuminate\Http\Request;

class ArrondissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arrondissements = Arrondissement::all();

        return response()->json([
            'success' => true,
            'data' => $arrondissements,
            'message' => 'Liste des arrondissements récupérée avec succès.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'commune_id' => 'required|exists:communes,id'
        ]);

        $arrondissement = new Arrondissement();
        $arrondissement->nom = $request->input('nom');
        $arrondissement->commune_id = $request->input('commune_id');

        $arrondissement->save();

        return response()->json([
            'success' => true,
            'data' => $arrondissement,
            'message' => 'L\'arrondissement a été créé avec succès.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $arrondissement = Arrondissement::find($id);

        return response()->json([
            'success' => true,
            'data' => $arrondissement,
            'message' => 'Détails de l\'arrondissement récupérés avec succès.'
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'commune_id' => 'required|exists:communes,id',
        ]);

        $arrondissement = Arrondissement::find($id);

        $arrondissement->nom = $request->input('nom');
        $arrondissement->commune_id = $request->input('commune_id');

        $arrondissement->save();

        return response()->json([
            'success' => true,
            'data' => $arrondissement,
            'message' => 'Arrondissement mis à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $arrondissement = Arrondissement::find($id);

        $arrondissement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Arrondissement supprimé avec succès.'
        ]);
    }
}
