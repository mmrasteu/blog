<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.edit')->only('edit', 'update');
        $this->middleware('can:users.destroy')->only('destroy');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::simplePaginate(10);

        return view('admin.users.index', compact('users'));
    }
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //Recuperar el listado de roles
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //Llenar la tabla intermedia entre roles y usuarios
        $user->roles()->sync($request->role);

        return redirect()->route('users.edit', $user)
                        ->with('success-update', 'Rol establecido con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->action([UserController::class, 'index'])
                        ->with('success-delete', 'Usuario eliminado con éxito');
    }
}
