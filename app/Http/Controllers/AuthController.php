<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'required|string|unique:users',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'join_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
            }

            // Start database transaction
            DB::beginTransaction();

            try {
                // Create the user with default role 'pegawai'
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->nip = $request->nip;
                $user->position = $request->position;
                $user->role = 'pegawai'; // Default role for new registrations
                $user->is_active = true; // Set to true to make them visible immediately
                $user->save();

                // Handle photo upload
                $photoPath = null;
                if ($request->hasFile('photo')) {
                    $photoPath = $request->file('photo')->store('profile-photos', 'public');
                }

                // Create profile for the user
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->phone = $request->phone;
                $profile->address = $request->address;
                $profile->department = $request->department;
                $profile->join_date = $request->join_date;
                $profile->bio = $request->bio ?? 'Pegawai ' . $request->department;
                $profile->photo = $photoPath;
                // Set default values for social media fields to prevent null errors
                $profile->website = '';
                $profile->facebook = '';
                $profile->twitter = '';
                $profile->instagram = '';
                $profile->linkedin = '';
                $profile->save();

                // Commit the transaction
                DB::commit();

            } catch (\Exception $e) {
                // Rollback the transaction on error
                DB::rollBack();
                // Delete the uploaded photo if there was an error
                if (isset($photoPath) && Storage::disk('public')->exists($photoPath)) {
                    Storage::disk('public')->delete($photoPath);
                }
                throw $e; // Re-throw the exception to be caught by the outer try-catch
            }

            // Don't login automatically, wait for admin approval
            // Auth::login($user);

            return redirect('/login')
                ->with('status', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan admin.');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Registration error: ' . $e->getMessage());
            
            // Return with error message
            return back()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.')
                         ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}