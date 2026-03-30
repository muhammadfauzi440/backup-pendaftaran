<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Gate;
class ProfileController extends Controller
{
    public function index()
    {   
        $user = Auth::user();

        if ($user->role == 'admin') {
            $allUsers = User::where('id', '!=', $user->id)->orderBy('role', 'asc')->get();
            return view('admin.users.index', compact('allUsers'));
        } else {
            return view('user.akun', compact('user'));
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'string', 'min:6'],
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Pengguna baru berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $userToDelete = User::findOrFail($id);

        Gate::authorize('delete', $userToDelete);

        $userToDelete->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus beserta seluruh data');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();
        
        if ($currentUser->role !== 'admin') {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengedit pengguna');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();
        
        if ($currentUser->role !== 'admin') {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah pengguna');
        }
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
        
        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui');
    }
}