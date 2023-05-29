<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InfoUserController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('user-manager/admin-profile', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $attributes = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore($user->id)],
            'phone' => ['max:50'],
            'location' => ['max:70'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Remove the 'password' field from the attributes array if it is empty
        if (empty($attributes['password'])) {
            unset($attributes['password']);
        } else {
            // Hash the password if it is not empty
            $attributes['password'] = bcrypt($attributes['password']);
        }

        $user->update($attributes);

        return redirect('/admin-profile')->with('success', 'Profile updated successfully');
    }
}
