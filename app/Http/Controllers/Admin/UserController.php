<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Counter;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('counter')
            ->where('role', 'cashier')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $counters = Counter::available()->get();
        return view('admin.users.create', compact('counters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'counter_id' => 'nullable|exists:counters,id'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'cashier'
        ]);

        if ($validated['counter_id']) {
            Counter::find($validated['counter_id'])
                ->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Cajero creado exitosamente');
    }

    public function edit(User $user)
    {
        $counters = Counter::available()->get();
        return view('admin.users.edit', compact('user', 'counters'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|confirmed',
            'counter_id' => 'nullable|exists:counters,id'
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email']
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        $user->update($updateData);

        // Actualizar relación con taquilla
        Counter::where('user_id', $user->id)->update(['user_id' => null]);
        if ($validated['counter_id']) {
            Counter::find($validated['counter_id'])
                ->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Cajero actualizado');
    }

    public function destroy(User $user)
    {
        // Liberar taquilla asociada
        Counter::where('user_id', $user->id)->update(['user_id' => null]);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Cajero eliminado');
    }
}
