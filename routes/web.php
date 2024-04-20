<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

//Principal
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

//Administrador
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

//Rutas del admin
Route::namespace('App\Http\Controllers')->prefix('admin')->group(function () {
    //Articulos
    Route::resource('articles', 'ArticleController')
                ->except('show')
                ->names('articles');
    //Categorias
    Route::resource('categories', 'CategoryController')
                ->except('show')
                ->names('categories');
    //Comentarios
    Route::resource('comments', 'CommentController')
                ->only('index', 'destroy')
                ->names('comments');
});

// Articulos
Route::resource('articles', ArticleController::class)
                ->except('show')
                ->names('admin.articles');

// Categorias
Route::resource('categories', CategoryController::class)
                ->except('show')
                ->names('admin.categories');

// Comentarios
Route::resource('comments', CommentController::class)
                ->only('index', 'destroy')
                ->names('admin.comments');

// Perfiles
Route::resource('profiles', ProfileController::class)
    ->only('edit', 'update')
    ->names('profiles');

//Ver articulos
Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');            

//Ver articulos por categorias
Route::get('/category/{category}', [CategoryController::class, 'detail'])->name('categories.detail');

//Ver perfil de usuario
Route::get('/profile/{profile}', [ProfileController::class, 'show'])->name('profiles.show');


//Guardar los comentarios
Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');

// Esto se pone al final normalmente
Auth::routes();

/*
resource hace lo mismo que todo esto de abajo
Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('article.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('article.store');

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('article.edit');
Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('article.update');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');
*/