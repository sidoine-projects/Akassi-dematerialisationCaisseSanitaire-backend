<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
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
            'pays_id' => 'required|exists:pays,id',
            'departement_id' => 'required|exists:departements,id',
            'commune_id' => 'required|exists:communes,id',
            'arrondissement_id' => 'required|exists:arrondissements,id',
            'quartier_id' => 'required|exists:quartiers,id',
            'situationmatrimoniale' => 'required|string',
        ]);

        // Récupérer l'ID de l'utilisateur connecté
        $userId = auth()->user()->id;

        // Création du patient avec user_id
        $patient = Patient::create([
            'user_id' => $userId, // Ajouter user_id
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
            'pays_id' => $validatedData['pays_id'],
            'departement_id' => $validatedData['departement_id'],
            'commune_id' => $validatedData['commune_id'],
            'arrondissement_id' => $validatedData['arrondissement_id'],
            'quartier_id' => $validatedData['quartier_id'],
            'situationmatrimoniale' => $validatedData['situationmatrimoniale'],
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
    public function show($id)
    {
        // Recherche du patient
        $patient = Patient::find($id);

        // Vérification si le patient existe
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient introuvable.'
            ], 404);
        }

        // Vérification si le patient appartient à l'utilisateur connecté
        if ($patient->user_id !== auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé.'
            ], 403);
        }

        // Réponse JSON avec les données du patient
        return response()->json([
            'success' => true,
            'data' => $patient
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
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
            'pays_id' => 'required|exists:pays,id',
            'departement_id' => 'required|exists:departements,id',
            'commune_id' => 'required|exists:communes,id',
            'arrondissement_id' => 'required|exists:arrondissements,id',
            'quartier_id' => 'required|exists:quartiers,id',
            'situationmatrimoniale' => 'required|string',
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

        // Vérification si le patient appartient à l'utilisateur connecté
        if ($patient->user_id !== auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé.'
            ], 403);
        }

        // Mise à jour des données du patient
        $patient->nom = $request->nom;
        $patient->prenom = $request->prenom;
        $patient->email = $request->email;
        $patient->adresse = $request->adresse;
        $patient->age = $request->age;
        $patient->telephone = $request->telephone;
        $patient->whatsapp = $request->whatsapp;
        $patient->profession = $request->profession;
        $patient->urgencecontact = $request->urgencecontact;
        $patient->sexe = $request->sexe;
        $patient->autre = $request->autre;
        $patient->pays_id = $request->pays_id;
        $patient->departement_id = $request->departement_id;
        $patient->commune_id = $request->commune_id;
        $patient->arrondissement_id = $request->arrondissement_id;
        $patient->quartier_id = $request->quartier_id;
        $patient->situationmatrimoniale = $request->situationmatrimoniale;
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
        // Recherche du patient par ID
        $patient = Patient::find($id);

        // Vérification si le patient existe
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient introuvable.'
            ], 404);
        }

        // Vérification si le patient appartient à l'utilisateur connecté
        if ($patient->user_id !== auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé.'
            ], 403);
        }

        // Suppression du patient
        $patient->delete();

        // Réponse JSON avec un message de succès
        return response()->json([
            'success' => true,
            'message' => 'Patient supprimé avec succès.'
        ]);
    }
}
