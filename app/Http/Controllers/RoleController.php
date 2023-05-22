<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::all();

        $response = [
            'success' => true,
            'data' => $roles,
            'message' => 'Liste des rôles.'
        ];

        return response()->json($response);
    }
    public function droitUsers(Request $request)
    {
        $role = Role::find($request->role);

        foreach ($request->permissions as $permission) {
            $permissions = Permission::find($permission);
            $role->givePermissionTo($permissions);
            // $permission->assignRole($role);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required|min:10',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);


        $response = [
            'success' => true,
            'data' => $role,
            'message' => 'Rôle créé avec succès.'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    // public function show(Role $role)
    // {
    //     //
    //      // Recherche de la permission
    //      $role = Role::find($id);

    //      // Vérification si la permission existe
    //      if (!$role) {
    //          return response()->json([
    //              'success' => false,
    //              'message' => 'Rôle introuvable.'
    //          ], 404);
    //      }

    //      // Réponse JSON avec les données de la permission
    //      return response()->json([
    //          'success' => true,
    //          'data' => $role
    //      ]);
    // }
    public function show($id)
    {
        // Recherche du rôle
        $role = Role::find($id);

        // Vérification si le rôle existe
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle introuvable.'
            ], 404);
        }

        // Réponse JSON avec les données du rôle
        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Role $role)
    // {
    //     //
    // }
    public function update(Request $request, $id)
    {
        // Validation des données entrantes
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required|min:10',
        ]);

        // Recherche du rôle à mettre à jour
        $role = Role::find($id);

        // Vérification si le rôle existe
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle introuvable.'
            ], 404);
        }

        // Mise à jour des données du rôle
        $role->name = $request->name;
        $role->save();

        // Réponse JSON avec les données mises à jour du rôle
        return response()->json([
            'success' => true,
            'data' => $role,
            'message' => 'Rôle mis à jour avec succès.'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Role $role)
    // {
    //     //
    // }
    public function destroy($id)
    {
        // Recherche du rôle à supprimer
        $role = Role::find($id);

        // Vérification si le rôle existe
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle introuvable.'
            ], 404);
        }

        // Suppression du rôle
        $role->delete();

        // Réponse JSON avec un message de succès
        return response()->json([
            'success' => true,
            'message' => 'Rôle supprimé avec succès.'
        ]);
    }
}
