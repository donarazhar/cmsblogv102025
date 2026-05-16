<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $users = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => User::count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
            'recent' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,staff',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'email_verified_at' => $request->has('email_verified') ? now() : null,
        ]);

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('User baru ditambahkan: ' . $user->name);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User "' . $user->name . '" berhasil ditambahkan!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Load recent activity logs for this user
        $activities = $user->actions()->latest()->take(20)->get();

        return view('admin.users.show', compact('user', 'activities'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,staff',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role harus dipilih',
            'role.in' => 'Role tidak valid',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update role (prevent self-demotion)
        if ($user->id !== auth()->id()) {
            $user->role = $validated['role'];
        }

        // Only update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Handle email verification toggle
        if ($request->has('email_verified')) {
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
            }
        } else {
            $user->email_verified_at = null;
        }

        $user->save();

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('User diupdate: ' . $user->name);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User "' . $user->name . '" berhasil diupdate!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $name = $user->name;

        // Log activity before delete
        activity()
            ->causedBy(auth()->user())
            ->log('User dihapus: ' . $name);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User "' . $name . '" berhasil dihapus!');
    }

    /**
     * Change password form for a specific user.
     */
    public function changePassword(User $user)
    {
        return view('admin.users.change-password', compact('user'));
    }

    /**
     * Update the password for a specific user.
     */
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('Password user direset: ' . $user->name);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Password user "' . $user->name . '" berhasil diubah!');
    }

    /**
     * Show edit form for current logged-in user (accessible by all roles).
     */
    public function editSelf()
    {
        $user = auth()->user();
        return view('admin.users.edit-self', compact('user'));
    }

    /**
     * Update current logged-in user's own account.
     */
    public function updateSelf(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->log('Akun sendiri diupdate: ' . $user->name);

        return redirect()
            ->route('admin.my-account')
            ->with('success', 'Akun Anda berhasil diperbarui!');
    }
}
