<?php

namespace App\Http\Controllers;

use App\Models\Product;
//use http\Client\Curl\User;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function assignRole(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return response()->json(['message' => 'This user doesn\'t exist!']);
        }

        $user->syncRoles([$request->name]);

        return response()->json([
            'message' => 'Role assigned successfully!',
        ]);
    }

    public function removeRole(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['Message' => "This user doesn't exist!"]);
        }
        // $user->removeRole($request->name);
        $user->syncRoles("user");
        return response()->json([
            'Message' => 'Role removed successfully!',
        ]);
    }
}
