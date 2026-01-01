<?php

namespace App\Http\Controllers;

use App\Models\Venture;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VentureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    /**
     * Muestra el listado de emprendimientos.
     */
    public function index()
    {
        $entrepreneurId = Auth::user()->entrepreneur->id;

        $ventures = Venture::where('entrepreneur_id', $entrepreneurId)->withCount('products')->orderBy('created_at', 'desc')->paginate(9);

        return view('app.back.emprendedor.emprendimientos.ver-emprendimientos', compact('ventures'));
    }

    /**
     * Muestra el formulario para crear un nuevo emprendimiento.
     */
    public function create()
    {
        $categories = Category::all();
        return view('app.back.emprendedor.emprendimientos.create-emprendimi', compact('categories'));
    }

    /**
     * Almacena un nuevo emprendimiento y sus productos en la base de datos.
     * Valida los datos y utiliza transacciones.
     */
    public function store(Request $request)
    {
        // Validación de datos del formulario y productos
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:5120', // 5MB Max
            'products' => 'nullable|array',
            'products.*.title' => 'required|string|max:255',
            'products.*.description' => 'required|string',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.image' => 'required|image|max:5120',
        ]);

        try {
            // Inicia transacción de base de datos
            DB::beginTransaction();

            $entrepreneurId = Auth::user()->entrepreneur->id;


            // 1. Guardar Venture usando Storage
            $imagePath = $request->file('image')->store('ventures', 'public');

            $venture = Venture::create([
                'entrepreneur_id' => $entrepreneurId,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'image' => $imagePath,
                'description' => $request->description,
                'location' => $request->location,
                'status' => 'inactive', // Por defecto inactivo como solicitado
            ]);

            // 2. Guardar Productos asociados
            if ($request->has('products')) {
                foreach ($request->products as $key => $productData) {
                    if (isset($productData['image']) && $request->hasFile("products.$key.image")) {
                        // Guardar imagen de producto usando Storage
                        $productImage = $request->file("products.$key.image")->store('products', 'public');

                        $venture->products()->create([
                            'title' => $productData['title'],
                            'description' => $productData['description'],
                            'price' => $productData['price'],
                            'image' => $productImage,
                        ]);
                    }
                }
            }

            // Confirma la transacción
            DB::commit();

            return redirect()->route('entrepreneur.emprendimientos.index')
                ->with('swal_success', 'Emprendimiento creado exitosamente.');
        } catch (\Exception $e) {
            // Revierte cambios si hay error
            DB::rollBack();
            // Eliminar imagen subida si falló la transacción (opcional pero recomendado)
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            return back()->with('swal_error', 'Error al guardar: ' . $e->getMessage())->withInput();
        }
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
    public function edit(string $id)
    {
        $entrepreneurId = Auth::user()->entrepreneur->id;

        // Verificar que el emprendimiento pertenece al usuario autenticado
        $venture = Venture::where('id', $id)
            ->where('entrepreneur_id', $entrepreneurId)
            ->firstOrFail();

        $categories = Category::all();

        return view('app.back.emprendedor.emprendimientos.edit-emprendimiento', compact('venture', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
        ]);

        try {
            $entrepreneurId = Auth::user()->entrepreneur->id;

            // Verificar que el emprendimiento pertenece al usuario autenticado
            $venture = Venture::where('id', $id)
                ->where('entrepreneur_id', $entrepreneurId)
                ->firstOrFail();

            DB::beginTransaction();

            // Verificar si la categoría cambió
            // $categoryChanged = $venture->category_id != $request->category_id; // Removed as requested

            // Actualizar imagen si se proporciona una nueva
            if ($request->hasFile('image')) {
                // Eliminar imagen anterior
                if ($venture->image) {
                    Storage::disk('public')->delete($venture->image);
                }
                // Guardar nueva imagen
                $imagePath = $request->file('image')->store('ventures', 'public');
                $venture->image = $imagePath;
            }

            // Actualizar datos del emprendimiento
            $venture->category_id = $request->category_id;
            $venture->title = $request->title;
            $venture->description = $request->description;
            $venture->location = $request->location;
            $venture->save();

            // Si la categoría cambió, actualizar la categoría de todos los productos
            DB::commit();

            $message = 'Emprendimiento actualizado exitosamente.';
            // if ($categoryChanged) {
            //    $message .= ' La categoría de todos los productos también fue actualizada.';
            // }

            return redirect()->route('entrepreneur.emprendimientos.index')
                ->with('swal_success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('swal_error', 'Error al actualizar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $entrepreneurId = Auth::user()->entrepreneur->id;

            // Verificar que el emprendimiento pertenece al usuario autenticado
            $venture = Venture::where('id', $id)
                ->where('entrepreneur_id', $entrepreneurId)
                ->firstOrFail();

            DB::beginTransaction();

            // Eliminar imágenes de productos
            foreach ($venture->products as $product) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
            }

            // Eliminar productos
            $venture->products()->delete();

            // Eliminar imagen del emprendimiento
            if ($venture->image) {
                Storage::disk('public')->delete($venture->image);
            }

            // Eliminar emprendimiento
            $venture->delete();

            DB::commit();

            return redirect()->route('entrepreneur.emprendimientos.index')
                ->with('swal_success', 'Emprendimiento eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('swal_error', 'Error al eliminar el emprendimiento: ' . $e->getMessage());
        }
    }
}
