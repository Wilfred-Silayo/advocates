<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query()->where('role', 'admin');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $admins = $query->paginate(10);

        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
    }

    public function edit(User $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|unique:users,phone,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'password' => $request->filled('password') ? bcrypt($request->password) : $admin->password,
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin updated successfully.');
    }


    public function show($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.show', compact('admin'));
    }


    public function search(Request $request)
    {
        try {
            $query = $request->input('search');
            $admins = User::where('role', 'admin')
                ->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('email', 'LIKE', "%{$query}%");
                })
                ->paginate(10);

            if ($request->ajax()) {
                return response()->json([
                    'html' => view('admins.table', compact('admins'))->render(),
                    'pagination' => (string) $admins->links()->render()
                ]);
            }

            return view('admins.index', compact('admins'));
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Search error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }



    public function destroy(User $admin)
    {
        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Admin deleted successfully.');
    }
}
