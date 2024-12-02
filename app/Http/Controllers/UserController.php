<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('user.user_list.index', compact('user'));
    }

    public function show($id)
    {
        $user = User::findorfail($id);
        return view('user.user_list.show', compact('user'));
    }

    public function create()
    {
        return view('user.user_list.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8',
        ], [
            'username.unique' => 'The username is already registered.',
            'email.unique' => 'The email address is already registered.',
        ]);

        if ($validatedData['password'] !== $validatedData['password_confirmation']) {
            return redirect()->back()->withErrors(['password' => 'Password and confirmation password do not match.']);
        }

        try {
            $user = new User();
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            return redirect()->route('user.index')->with('success', 'Registration successful');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create the user. Please try again.');
        }
    }

    public function update(Request $request, User $user)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo_path' => 'image|file|max:2048',
        ]);

        if (!empty($user->profile_photo_path) && $request->hasFile('profile_photo_path')) {
            $imagePath = $user->profile_photo_path;

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        if ($profile_photo_path = $request->file('profile_photo_path')) {
            $destinationPath = 'images/user/';
            $profileImage = "user" . "-" . date('YmdHis') . "." . $profile_photo_path->getClientOriginalExtension();
            $profile_photo_path->move($destinationPath, $profileImage);
            $validateData['profile_photo_path'] = $destinationPath . $profileImage;
        } elseif (!$request->hasFile('profile_photo_path') && !$user->profile_photo_path) {
            unset($validateData['profile_photo_path']);
        }

        $user->update($validateData);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
}
