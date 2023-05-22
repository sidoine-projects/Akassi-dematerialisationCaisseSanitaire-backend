<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }
    public function index()
    {
        $users = Patient::all();

        return response()->json([
            'success' => true,
            'data' => $users,
            'message' => 'Liste des patients.'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }
    public function store(Request $request)
    {
        // Validation des données de la requête
        $validatedData = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'age' => 'required|numeric',
            'adresse' => 'required',
            'telephone' => 'required',
            'email' => 'required|email|unique:patients',
            'whatsapp' => 'required',
            'profession' => 'required',
            'sexe' => 'required',
            'urgencecontact' => 'required|string',
            'autre' => 'nullable|string',
        ]);

        // Création du patient
        $patient = Patient::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'age' => $validatedData['age'],
            'adresse' => $validatedData['adresse'],
            'telephone' => $validatedData['telephone'],
            'email' => $validatedData['email'],
            'whatsapp' => $validatedData['whatsapp'],
            'profession' => $validatedData['profession'],
            'sexe' => $validatedData['sexe'],
            'urgencecontact' => $validatedData['urgencecontact'],
            'autre' => $validatedData['autre'],
        ]);

        return response()->json([
            'success' => true,
            'data' => $patient,
            'message' => 'Patient créé avec succès.'
        ]);
    }


    /**
     * Display the specified resource.
     */
    // public function show(Patient $patient)
    // {
    //     //
    // }
    public function show($id)
    {
        // Recherche de la permission
        $patient = Patient::find($id);

        // Vérification si la permission existe
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient introuvable.'
            ], 404);
        }

        // Réponse JSON avec les données de la permission
        return response()->json([
            'success' => true,
            'data' => $patient
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Patient $patient)
    // {
    //     //
    // }
    public function update(Request $request, string $id)
    {
        // Validation des données entrantes
        $validatedData = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:patients,email,' . $id,
            'adresse' => 'required|string',
            'age' => 'required|numeric',
            'telephone' => 'required|string',
            'whatsapp' => 'required|string',
            'profession' => 'required|string',
            'urgencecontact' => 'required|string',
            'sexe' => 'required|string',
            'autre' => 'nullable|string',
        ]);

        // Recherche du patient par ID
        $patient = Patient::find($id);

        // Vérification si le patient existe
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient introuvable.'
            ], 404);
        }

        // Mise à jour des données du patient
        $patient->nom = $validatedData['nom'];
        $patient->prenom = $validatedData['prenom'];
        $patient->email = $validatedData['email'];
        $patient->adresse = $validatedData['adresse'];
        $patient->age = $validatedData['age'];
        $patient->telephone = $validatedData['telephone'];
        $patient->whatsapp = $validatedData['whatsapp'];
        $patient->profession = $validatedData['profession'];
        $patient->urgencecontact = $validatedData['urgencecontact'];
        $patient->sexe = $validatedData['sexe'];
        $patient->autre = $validatedData['autre'];
        $patient->save();

        // Réponse JSON avec les données mises à jour du patient
        return response()->json([
            'success' => true,
            'data' => $patient,
            'message' => 'Informations du patient mises à jour avec succès.'
        ]);
    }




    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Patient $patient)
    // {
    //     //
    // }
    public function destroy(string $id)
    {
        // Recherche de l'utilisateur par ID
        $patient = Patient::find($id);

        // Vérification si l'utilisateur existe
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient introuvable.'
            ], 404);
        }

        // Suppression de l'utilisateur
        $patient->delete();

        // Réponse JSON avec un message de succès
        return response()->json([
            'success' => true,
            'message' => 'Patient supprimé avec succès.'
        ]);
    }
}
