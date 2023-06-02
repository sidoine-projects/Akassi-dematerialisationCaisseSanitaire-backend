<?php

namespace App\Http\Controllers;

use App\Models\MedicalAct;
use Illuminate\Http\Request;

class ActMedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = auth()->user()->id;

        // Récupérer les actes médicaux de l'utilisateur
        $medicalActs = MedicalAct::where('user_id', $userId)->get();

        // Réponse JSON avec les actes médicaux de l'utilisateur
        return response()->json([
            'success' => true,
            'data' => $medicalActs,
            'message' => 'Liste des actes médicaux de l\'utilisateur.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données de la requête
        $validatedData = $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'tarif' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        // Récupérer l'ID de l'utilisateur connecté
        $userId = auth()->user()->id;

        // Création de l'acte médical avec user_id
        $medicalAct = MedicalAct::create([
            'code' => $validatedData['code'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'tarif' => $validatedData['tarif'],
            'user_id' => $userId, // Ajouter user_id
        ]);

        return response()->json([
            'success' => true,
            'data' => $medicalAct,
            'message' => 'Acte médical créé avec succès.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Recherche de l'acte médical par ID
        $medicalAct = MedicalAct::find($id);

        // Vérification si l'acte médical existe
        if (!$medicalAct) {
            return response()->json([
                'success' => false,
                'message' => 'Acte médical introuvable.'
            ], 404);
        }

        // Vérification si l'acte médical appartient à l'utilisateur connecté
        if ($medicalAct->user_id !== auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $medicalAct,
            'message' => 'Détails de l\'acte médical récupérés avec succès.'
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'code' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string',
            'tarif' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        // Recherche de l'acte médical par ID
        $medicalAct = MedicalAct::find($id);

        // Vérification si l'acte médical existe
        if (!$medicalAct) {
            return response()->json([
                'success' => false,
                'message' => 'Acte médical introuvable.'
            ], 404);
        }

        // Vérification si l'acte médical appartient à l'utilisateur connecté
        if ($medicalAct->user_id !== auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé.'
            ], 403);
        }

        // Mise à jour des données de l'acte médical
        $medicalAct->code = $request->code;
        $medicalAct->name = $request->name;
        $medicalAct->description = $request->description;
        $medicalAct->tarif = $request->tarif;
        $medicalAct->save();

        return response()->json([
            'success' => true,
            'data' => $medicalAct,
            'message' => 'Acte médical mis à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Recherche de l'acte médical par ID
        $medicalAct = MedicalAct::find($id);

        // Vérification si l'acte médical existe
        if (!$medicalAct) {
            return response()->json([
                'success' => false,
                'message' => 'Acte médical introuvable.'
            ], 404);
        }

        // Vérification si l'acte médical appartient à l'utilisateur connecté
        if ($medicalAct->user_id !== auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé.'
            ], 403);
        }

        // Suppression de l'acte médical
        $medicalAct->delete();

        return response()->json([
            'success' => true,
            'message' => 'Acte médical supprimé avec succès.'
        ]);
    }
}
