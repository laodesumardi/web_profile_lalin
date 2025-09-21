<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        return view('profile.show', compact('user', 'profile'));
    }

    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        return view('profile.edit', compact('user', 'profile'));
    }

    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Password berhasil diubah!');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nip' => 'required|string|unique:users,nip,' . $user->id,
            'position' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'position' => $request->position,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update or create profile
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
        
        $photoPath = $profile->photo;
        if ($request->hasFile('photo')) {
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $photoPath = $request->file('photo')->store('profiles', 'public');
        }

        $profileData = [
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->bio,
            'photo' => $photoPath,
        ];

        if ($profile->exists) {
            $profile->update($profileData);
        } else {
            $profile->fill($profileData);
            $profile->user_id = $user->id;
            $profile->save();
        }

        return redirect()->route('profile.show')->with('success', 'Profile berhasil diperbarui!');
    }
}
