<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('plan')->latest()->paginate(15);
        $plans = Plan::all();
        
        return view('admin.users.index', compact('users', 'plans'));
    }

    public function create()
    {
        $plans = Plan::all();
        return view('admin.users.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,creator',
            'plan_id' => 'nullable|exists:plans,id',
            'is_active' => 'boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'plan_id' => $request->plan_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    public function show(User $user)
    {
        $user->load(['plan', 'websites']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $plans = Plan::all();
        return view('admin.users.edit', compact('user', 'plans'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,creator',
            'plan_id' => 'nullable|exists:plans,id',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'plan_id' => $request->plan_id,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        // Verificar si el usuario tiene sitios web
        if ($user->websites()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No se puede eliminar el usuario porque tiene sitios web asociados');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activado' : 'desactivado';
        return redirect()->route('admin.users.index')
            ->with('success', "Usuario {$status} exitosamente");
    }
}
