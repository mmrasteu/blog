<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Mostrar los articulos en el admin
        //Auth::user() muestra la informacion del usuario autenticado
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->simplePaginate(10);

        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Obtener categorias publicas
        $categories = Category::select(['id', 'name'])
                                ->where('status', '1')
                                ->get();

        return view('admin.article.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        // Unir los datos que vienen del formulario ($request) con los datos que yo quiero guardar y 
        // que no quiero que se vean por ejemplo el user id del creador. Desde el backend yo le estoy dando
        // al request el id del usuario que ha mandado este request
        $request->merge([
            'user_id' => Auth::user()->id,
        ]);

        // Guardar la solicitud en una variable
        $article = $request->all();

        // Validar si hay un archivo en el request

        if($request->hasFile('image')){
            $article['image'] = $request->file('image')->store('articles');
        }

        Article::create($article);

        return redirect()->action([ArticleController::class, 'index'])
                            ->width('success-create', 'Articulo creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $comments = $article->comments()->simplePaginate(5);

        return view('subscriber.articles.show', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::select(['id', 'name'])
                                ->where('status', '1')
                                ->get();

        return view('admin.article.edit', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Article $request, Article $article)
    {
        //Si el usuario sube una nueva imagen
        if ($request->hasFile('image')) { 
            // Eliminar imagen anterior
            File::delete(public_path('storage/' . $article->image));
            // Asigna nueva imagen
            $article['image'] = $request->file('image')->store('articles');
        }

        // Actualizar datos
        $article->update([
            'title'         => $request->title,
            'slug'          => $request->slug,
            'introduction'  => $request->introduction,
            'body'          => $request->body,
            'user_id'       => Auth::user()->id,
            'category_id'   => $request->category_id,
            'status'        => $request->status,
        ]);

        return redirect()->action([ArticleController::class, 'index'])
                            ->width('success-update', 'Articulo modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Eliminar imagen de articulo cuando se borre el articulo
        if ($article->image) { 
            File::delete(public_path('storage/' . $article->image));
        }

        // Eliminar articulo
        $article->delete();

        return redirect()->action([ArticleController::class, 'index'], compact('article'))
                            ->width('success-delete', 'Articulo eliminado con exito');
    }
}
