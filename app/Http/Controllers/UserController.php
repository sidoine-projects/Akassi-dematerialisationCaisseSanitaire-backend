<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\User;


class UserController extends Controller
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
        // Récupération de tous les utilisateurs
        $users = User::all();

        // Réponse JSON avec les données des utilisateurs
        return response()->json([
            'success' => true,
            'data' => $users
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
        // Validation des données entrantes
        $validatedData = $request->validate([
            'name' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users',
            'nom_utilisateur' => 'required|string|unique:users',
            'adresse' => 'required|string',
            'role_id' => 'required|integer',
            'telephone' => 'required|string|min:8',
            'sexe' => 'required|string',
            'password' => 'required|string',
        ]);

        // Création d'un nouvel utilisateur
        $user = User::create([
            'name' => $validatedData['name'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['email'],
            'nom_utilisateur' => $validatedData['nom_utilisateur'],
            'adresse' => $validatedData['adresse'],
            'role_id' => $validatedData['role_id'],
            'telephone' => $validatedData['telephone'],
            'sexe' => $validatedData['sexe'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Réponse JSON avec les données du nouvel utilisateur
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Utilisateur créé avec succès.'
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }
    public function show(string $id)
    {
        // Recherche de l'utilisateur par ID
        $user = User::find($id);

        // Vérification si l'utilisateur existe
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur introuvable.'
            ], 404);
        }

        // Réponse JSON avec les données de l'utilisateur
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }
    public function update(Request $request, string $id)
    {
        // Validation des données entrantes
        $validatedData = $request->validate([
            'name' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'nom_utilisateur' => 'required|string|unique:users,nom_utilisateur,' . $id,
            'adresse' => 'required|string',
            'role_id' => 'required|string',
            'telephone' => 'required|string',
            'sexe' => 'required|string',
            'password' => 'required|string',
        ]);

        // Recherche de l'utilisateur par ID
        $user = User::find($id);

        // Vérification si l'utilisateur existe
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur introuvable.'
            ], 404);
        }

        // Mise à jour des données de l'utilisateur

        $user->name = $validatedData['name'];
        $user->prenom = $validatedData['prenom'];
        $user->email = $validatedData['email'];
        $user->nom_utilisateur = $validatedData['nom_utilisateur'];
        $user->adresse = $validatedData['adresse'];
        $user->role_id = $validatedData['role_id'];
        $user->telephone = $validatedData['telephone'];
        $user->sexe = $validatedData['sexe'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        // Réponse JSON avec les données mises à jour de l'utilisateur
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Utilisateur mis à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
    public function destroy(string $id)
    {
        // Recherche de l'utilisateur par ID
        $user = User::find($id);

        // Vérification si l'utilisateur existe
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur introuvable.'
            ], 404);
        }

        // Suppression de l'utilisateur
        $user->delete();

        // Réponse JSON avec un message de succès
        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès.'
        ]);
    }
}
