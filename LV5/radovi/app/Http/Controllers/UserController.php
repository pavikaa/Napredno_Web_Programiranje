<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getRoleEditingView($id){
        $user = User::findOrFail($id);
        return view('edit-role', ['selectedUser'=>$user]);
    }

    public function editRoleForUser(Request $request, $id){
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        return redirect('dashboard');
    }
}