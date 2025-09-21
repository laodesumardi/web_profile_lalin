<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * Display a listing of employees for admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function adminIndex(Request $request)
    {
        $query = User::with('profile')
            ->where('role', '!=', 'admin') // Exclude admin users
            ->latest();

        // Search by name, email, or NIP
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('nip', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('position', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('profile', function ($profileQuery) use ($searchTerm) {
                        $profileQuery->where('department', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        // Check if is_active column exists before filtering by status
        if ($request->filled('status')) {
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");
            $table = 'users';

            $columnExists = false;

            if ($driver === 'mysql') {
                $columnExists = \DB::select(
                    "SELECT COUNT(*) as count FROM information_schema.columns
                    WHERE table_schema = ? AND table_name = ? AND column_name = 'is_active'",
                    [config("database.connections.{$connection}.database"), $table]
                )[0]->count > 0;
            }

            if ($columnExists) {
                $query->where('is_active', $request->status === 'active');
            }
        }

        $employees = $query->paginate(15)->withQueryString();

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Display a listing of employees for public view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check if is_active column exists
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        $table = 'users';
        $columnExists = false;

        if ($driver === 'mysql') {
            $columnExists = \DB::select(
                "SELECT COUNT(*) as count FROM information_schema.columns
                WHERE table_schema = ? AND table_name = ? AND column_name = 'is_active'",
                [config("database.connections.{$connection}.database"), $table]
            )[0]->count > 0;
        }

        // Build the query
        $query = User::with('profile')
            ->where('role', 'pegawai')
            ->whereHas('profile')
            ->orderBy('name'); // Order by name

        // Only filter by is_active if the column exists
        if ($columnExists) {
            $query->where('is_active', true);
        }

        // Search by name, nip, or position
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('nip', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('position', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('profile', function ($profileQuery) use ($searchTerm) {
                        $profileQuery->where('department', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        // Get all positions for the filter dropdown from users table
        $positions = \App\Models\User::select('position')
            ->where('role', 'pegawai')
            ->whereNotNull('position')
            ->distinct()
            ->orderBy('position')
            ->pluck('position');

        $employees = $query->paginate(12)->withQueryString();

        return view('employees.index', compact('employees', 'positions'));
    }

    /**
     * Display the specified employee.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $employee = User::with(['profile', 'news' => function ($query) {
            $query->where('is_published', true)
                ->with('category')
                ->latest();
        }])->findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $positions = \App\Models\User::select('position')
            ->whereNotNull('position')
            ->distinct()
            ->orderBy('position')
            ->pluck('position');

        $departments = [
            'Keuangan',
            'SDM',
            'Operasional',
            'Pemasaran',
            'IT',
            'Hukum',
            'Umum',
            'Lainnya'
        ];

        return view('admin.employees.create', compact('positions', 'departments'));
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $employee = User::with('profile')->findOrFail($id);

        $positions = \App\Models\User::select('position')
            ->whereNotNull('position')
            ->distinct()
            ->orderBy('position')
            ->pluck('position');

        $departments = [
            'Keuangan',
            'SDM',
            'Operasional',
            'Pemasaran',
            'IT',
            'Hukum',
            'Umum',
            'Lainnya'
        ];

        return view('admin.employees.edit', compact('employee', 'positions', 'departments'));
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'nullable|string|max:50|unique:users',
            'role' => 'required|in:admin,pegawai',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'join_date' => 'nullable|date',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Start database transaction
        return \DB::transaction(function () use ($validated, $request) {
            // Create the user with position
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nip' => $validated['nip'] ?? null,
                'role' => $validated['role'],
                'position' => $validated['position'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
            }

            // Create the profile
            $user->profile()->create([
                'department' => $validated['department'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'join_date' => $validated['join_date'] ?? now(),
                'photo' => $photoPath,
            ]);

            return redirect()->route('admin.employees.index')
                ->with('success', 'Data pegawai berhasil ditambahkan.');
        });
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $id,
            'role' => 'required|in:admin,pegawai',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'join_date' => 'nullable|date',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Start database transaction
        return \DB::transaction(function () use ($validated, $request, $employee) {
            // Update the user
            $employee->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'nip' => $validated['nip'] ?? null,
                'role' => $validated['role'],
                'position' => $validated['position'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            // Update password if provided
            if (!empty($validated['password'])) {
                $employee->update(['password' => Hash::make($validated['password'])]);
            }

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
                // Delete old photo if exists
                if ($employee->profile && $employee->profile->photo) {
                    \Storage::disk('public')->delete($employee->profile->photo);
                }
            } else {
                $photoPath = $employee->profile->photo ?? null;
            }

            // Update or create the profile
            $employee->profile()->updateOrCreate([], [
                'department' => $validated['department'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'join_date' => $validated['join_date'] ?? now(),
                'photo' => $photoPath,
            ]);

            return redirect()->route('admin.employees.index')
                ->with('success', 'Data pegawai berhasil diperbarui.');
        });
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = User::findOrFail($id);

        // Prevent deleting admin users
        if ($employee->role === 'admin') {
            return redirect()->route('admin.employees.index')
                ->with('error', 'Tidak dapat menghapus akun admin.');
        }

        // Delete the employee's profile if it exists
        if ($employee->profile) {
            $employee->profile->delete();
        }

        // Delete the employee
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }
}