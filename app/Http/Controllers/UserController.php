<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    private $roles;

    public function __construct()
    {
        $this->roles = [
            ['id' => '', 'name' => 'Pilih Tipe'],
            ['id' => 'admin', 'name' => 'Admin'],
            ['id' => 'owner', 'name' => 'Owner'],
            ['id' => 'petugas', 'name' => 'Petugas'],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = User::paginate(10);
        return Inertia::render('User/Index', [
            'attr' => [
                'title' => 'User',
                'route_create' => route('users.create'),
                'models' => $models,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Create', [
            'attr' => [
                'form_type' => 'POST',
                'title' => 'Tambah User',
                'roles' => $this->roles,
                'model' => [],
                'route_url' => route('users.store'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'role' => ['required', 'in:admin,owner,petugas'],
        ],[],
        [
            'name' => 'Nama',
            'email' => 'Email',
            'role' => 'Role',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        if(User::create($validated)) {
            return redirect()->route('users.index')
                ->with('success', 'User berhasil ditambahkan.');
        }

        return redirect()->route('users.index')
                ->with('warnings', 'User gagal ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('User/Create', [
            'attr' => [
                'form_type' => 'PUT',
                'title' => 'Edit User',
                'roles' => $this->roles,
                'model' => $user,
                'route_url' => route('users.update', $user->id),
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', Rule::unique('users', 'name')->ignore($user->id)],
            'password' => ['nullable', 'min:8'],
            'role' => ['required', 'in:admin,owner,petugas'],
        ],[],
        [
            'name' => 'Nama',
            'email' => 'Email',
            'role' => 'Role',
        ]);
        
        if(isset($validated['password']) && !empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if($user->update($validated)) {
            return redirect()->route('users.index')
                ->with('success', 'User berhasil diupdate.');
        }

        return redirect()->route('users.index')
                ->with('warnings', 'User gagal diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->delete()) {
            return redirect()->route('users.index')
                ->with('success', 'User berhasil dihapus.');
        }

        return redirect()->route('users.index')
                ->with('warnings', 'User gagal dihapus.');
    }

}
