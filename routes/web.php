<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/all', [HomeController::class, 'all'])->name('home.all');

// Articulos
Route::resource('articles', ArticleController::class)
                ->except('show')
                ->names('articles');

// Categorias
Route::resource('categories', CategoryController::class)
                ->except('show')
                ->names('categories');

// Comentarios
Route::resource('comments', CommentController::class)
                ->only('index', 'destroy')
                ->names('comments');

// PErfiles
Route::resource('profiles', ProfileController::class)
    ->only('edit', 'update')
    ->names('profiles');

//Ver articulos
Route::get('article/{article}', [ArticleController::class, 'show'])->name('articles.show');            

//Ver articulos por categorias
Route::get('/category/{category}', [CategoryController::class, 'detail'])->name('categories.detail');

//Guardar los comentarios
Route::get('/comment', [CommentController::class, 'store'])->name('comments.store');

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