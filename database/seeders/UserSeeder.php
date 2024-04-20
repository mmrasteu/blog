<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //eliminar carpeta articles
        Storage::deleteDirectory('articles');

        //eliminar la carpeta categories
        Storage::deleteDirectory('categories');
 
        //crear carpeta articles
        Storage::makeDirectory('articles');
 
        //Crea la carpeta categories
        Storage::makeDirectory('categories');
         
        User::create([
            'full_name' => 'Admin',
            'email' => 'admin@correo.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'full_name' => 'Test',
            'email' => 'test@correo.com',
            'password' => Hash::make('12345678'),
        ]);

        User::factory(10)->create();
    }
}
