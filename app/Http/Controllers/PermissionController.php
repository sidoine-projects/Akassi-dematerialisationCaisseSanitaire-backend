<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        $response = [
            'success' => true,
            'data' => $permissions,
            'message' => 'Liste des permissions.'
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $permission = Permission::create(['name' => $request->name]);

        $response = [
            'success' => true,
            'data' => $permission,
            'message' => 'Permission créée avec succès.'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Recherche de la permission
        $permission = Permission::find($id);

        // Vérification si la permission existe
        if (!$permission) {
            return response()->json([
                'success' => false,
                'message' => 'Permission introuvable.'
            ], 404);
        }

        // Réponse JSON avec les données de la permission
        return response()->json([
            'success' => true,
            'data' => $permission
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données entrantes
        $this->validate($request, [
            'name' => 'required',
        ]);

        // Recherche de la permission à mettre à jour
        $permission = Permission::find($id);

        // Vérification si la permission existe
        if (!$permission) {
            return response()->json([
                'success' => false,
                'message' => 'Permission introuvable.'
            ], 404);
        }

        // Mise à jour des données de la permission
        $permission->name = $request->name;
        $permission->save();

        // Réponse JSON avec les données mises à jour
        return response()->json([
            'success' => true,
            'data' => $permission,
            'message' => 'Permission mise à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Recherche de la permission à supprimer
        $permission = Permission::find($id);

        // Vérification si la permission existe
        if (!$permission) {
            return response()->json([
                'success' => false,
                'message' => 'Permission introuvable.'
            ], 404);
        }

        // Suppression de la permission
        $permission->delete();

        // Réponse JSON avec un message de succès
        return response()->json([
            'success' => true,
            'message' => 'Permission supprimée avec succès.'
        ]);
    }

}