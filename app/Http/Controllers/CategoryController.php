<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Mostrar las categorias en el admin
        $categories = Category::orderBy('id', 'desc')
                    ->simplePaginate(8);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = $request->all();

        // Validar si hay un archivo en el request
        if($request->hasFile('image')){
            $category['image'] = $request->file('image')->store('categories');
        }

        //Guardar la informacion
        Category::create($category);

        return redirect()->action([CategoryController::class, 'index'])
                            ->with('success-create', 'Categoria creado con exito');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //Si el usuario sube una nueva imagen
        if ($request->hasFile('image')) { 
            // Eliminar imagen anterior
            File::delete(public_path('storage/' . $category->image));
            // Asigna nueva imagen
            $category['image'] = $request->file('image')->store('categories');
        }

        // Actualizar datos
        $category->update([
            'name'         => $request->name,
            'slug'          => $request->slug,
            'status'        => $request->status,
            'is_featured'   => $request->is_featured,
        ]);

        return redirect()->action([CategoryController::class, 'index'], compact('category'))
                            ->with('success-update', 'Categoria modificada con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Eliminar imagen de articulo cuando se borre el articulo
        if ($category->image) { 
            File::delete(public_path('storage/' . $category->image));
        }

        // Eliminar articulo
        $category->delete();

        return redirect()->action([CategoryController::class, 'index'], compact('category'))
                            ->with('success-delete', 'Categoria eliminada con exito');
    }

    //Filtrar arcitulso por categorias
    public function detail(Category $category)
    {   
        $this->authorize('published', $category);
        $articles = Article::where([
            ['category_id', $category->id],
            ['status', '1']
        ])
            ->orderBy('id','desc')
            ->simplePaginate(5);

        $navbar = Category::where([
            ['status', '1'],
            ['is_featured', '1']
        ])->paginate(3);

        return view('subscriber.categories.detail', compact('articles', 'category', 'navbar'));
    }
}
