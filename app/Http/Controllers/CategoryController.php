<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Muestra el listado de todas las categorías con paginación
     * 
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::withCount('ventures')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(4);

        $categories->appends(['search' => $search]); // Mantener el parámetro de búsqueda en la paginación

        if ($request->ajax()) {
            return view('app.back.admin.categorias.table-partial', compact('categories'))->render();
        }

        return view('app.back.admin.categorias.categoria', compact('categories'));
    }

    /**
     * 
     */
    public function create() {}

    /**
     * Almacena una nueva categoría en la base de datos
     * Valida los datos del formulario antes de guardar
     */
    public function store(Request $request)
    {
        // Valida los datos recibidos del formulario
        $validator = $request->validate([
            'name' => 'required|max:100|unique:categories,name',
            'description' => 'required|string',
        ]);

        // Crea y guarda la nueva categoría en la base de datos
        Category::create($validator);

        // Redirige al listado de categorías con un mensaje de éxito
        return redirect()->route('admin.categoria.index')->with('success', 'Categoría creada exitosamente');
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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Buscar la categoría por ID
        $category = Category::find($id);

        // Retornar la vista de edición correcta
        return view('app.back.admin.categorias.categoria-edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        // Validación usaando $id ya que es una excepcion por si no cambio el nombre de mi categoria ya que estaria detectando que esa categoria ya existe
        $request->validate([
            'name' => 'required|max:100|unique:categories,name,' . $id,
            'description' => 'required|string',
        ]);

        // Asignación manual
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return redirect()->route('admin.categoria.index')->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * FUNCION PARA ELIMINAR CATEGORIAS
     */
    public function destroy(string $id)
    {
        //buscamos el registro por id
        $categorie = Category::find($id);

        $categorie->delete();

        return redirect()->route('admin.categoria.index')->with('success', 'Categoría eliminada exitosamente');
    }
}
