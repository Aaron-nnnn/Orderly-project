<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function createRole(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|unique:roles,name',
        ]);

        $role = new Role();
        $role->name = $validated['name'];

        try{
            $role->save();
            return response()->json($role);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to Save the Role.',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function readAllRoles(){
        try{
             $roles = Role::all();
            return response()->json($roles);
            }
         catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Roles.',
                 'message'=>$exception->getMessage()
            ], 200);
         }
    }

    public function readRole($id){
        try{
            $role = Role::findOrFail($id);
            return response()->json($role);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Role',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function updateRole(Request $request, $id){
        $validated = $request->validate([
            'name'=>'required|string',
        ]);

        try{
            $role = Role::findOrFail($id);
            $role->name = $validated['name'];
            $role->save();
            return response()->json($role);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save the Role.',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function deleteRole($id){
        try{
            $role = Role::findOrFail($id);
            $role->delete();
            return response("Role deleted successfully!");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete the Role.',
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
