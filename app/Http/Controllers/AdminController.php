<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware is already applied at route level
    }

    public function index()
    {
        return $this->dashboard();
    }

    public function dashboard()
    {
        $totalNews = News::count();
        $totalUsers = User::where('role', 'pegawai')->count();
        $recentNews = News::latest()->take(5)->get();
        $recentUsers = User::where('role', 'pegawai')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalNews', 'totalUsers', 'recentNews', 'recentUsers'));
    }

    /**
     * Show the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        // Get all settings and group them by their group
        $settings = Setting::orderBy('group')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('group');

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update the application settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        // Get all settings from the database to build validation rules
        $settings = Setting::all();
        
        $validationRules = [];
        
        // Build validation rules based on settings in the database
        foreach ($settings as $setting) {
            $rules = [];
            
            // Set required rule if the setting is marked as required
            if ($setting->required) {
                $rules[] = 'required';
            } else {
                $rules[] = 'nullable';
            }
            
            // Add type-specific validation rules
            switch ($setting->type) {
                case 'email':
                    $rules[] = 'email';
                    break;
                case 'number':
                    $rules[] = 'numeric';
                    if (isset($setting->options['min'])) {
                        $rules[] = 'min:' . $setting->options['min'];
                    }
                    if (isset($setting->options['max'])) {
                        $rules[] = 'max:' . $setting->options['max'];
                    }
                    break;
                case 'text':
                case 'textarea':
                    $rules[] = 'string';
                    $rules[] = 'max:1000';
                    break;
                case 'json':
                    $rules[] = 'json';
                    break;
            }
            
            $validationRules[$setting->key] = implode('|', $rules);
        }
        
        // Validate the request
        $validated = $request->validate($validationRules);

        try {
            DB::beginTransaction();

            // Update each setting that was in the request
            foreach ($validated as $key => $value) {
                Setting::set($key, $value);
            }

            // Update config values for current request
            config(['app.name' => $validated['site_name']]);

            DB::commit();

            return redirect()
                ->route('admin.settings')
                ->with('success', 'Pengaturan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengaturan: ' . $e->getMessage());
        }
    }
}
