<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('user.index', compact('user'));
    }

    public function edit(Request $request)
    {
        foreach ($request->roles as $userId => $roles) {
            $user = User::find($userId);

            $user->is_store = $roles['store'];
            $user->is_workshop = $roles['workshop'];
            $user->is_wash = $roles['wash'];
            $user->is_hrm = $roles['hrm'];
            $user->is_setting = $roles['setting'];
            $user->is_user = $roles['user'];
            $user->is_estimator = $roles['estimator'];

            $user->save();
        }

        return redirect()->back()->with('success', 'Roles updated successfully.');
    }
}
