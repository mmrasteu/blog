<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {   
        $articles = Article::where([
            ['user_id', $profile->user_id], 
            ['status', '1']])->simplePaginate(8);
        
        return view('subscriber.profiles.show', compact('profile', 'articles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        $this->authorize('view', $profile);
        return view('subscriber.profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, Profile $profile)
    {   
        $this->authorize('update', $profile);
        $user = User::find(Auth::id());
        //Si el usuario sube una nueva imagen
        if ($request->hasFile('photo')) { 
            // Eliminar imagen anterior
            File::delete(public_path('storage/' . $profile->photo));
            // Asigna nueva imagen
            $photo = $request['photo']->store('profiles');
        } else {
            $photo = $user->profile->photo;
        }

        //Asignar nombre y correo
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        //Asignar foto
        $user->profile->photo = $photo;

        //Asignar campos adicionales 
        $user->profile->profession = $request->profession;
        $user->profile->about = $request->about;
        $user->profile->twitter = $request->twitter;
        $user->profile->linkedin = $request->linkedin;
        $user->profile->facebook = $request->facebook; 

        //Guardar campos de usuario
        $user->save();

        //Guardar campos de perfil
        $user->profile->save();

        return redirect()->route('profiles.edit', $user->profile->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
