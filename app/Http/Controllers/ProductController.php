<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Venture;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($ventureId)
    {
        $entrepreneurId = Auth::user()->entrepreneur->id;

        // Verificar que el emprendimiento pertenece al usuario autenticado
        $venture = Venture::where('id', $ventureId)
            ->where('entrepreneur_id', $entrepreneurId)
            ->firstOrFail();

        // Obtener los productos del emprendimiento
        $products = $venture->products()->orderBy('created_at', 'desc')->get();

        return view('app.back.emprendedor.productos.productos', compact('venture', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($ventureId)
    {
        $entrepreneurId = Auth::user()->entrepreneur->id;

        $venture = Venture::where('id', $ventureId)
            ->where('entrepreneur_id', $entrepreneurId)
            ->firstOrFail();

        return view('app.back.emprendedor.productos.create-productos', compact('venture'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $ventureId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|max:5120', // 5MB Max
        ]);

        try {
            $entrepreneurId = Auth::user()->entrepreneur->id;

            // Verificar que el emprendimiento pertenece al usuario
            $venture = Venture::where('id', $ventureId)
                ->where('entrepreneur_id', $entrepreneurId)
                ->firstOrFail();

            // Guardar imagen
            $imagePath = $request->file('image')->store('products', 'public');

            // Crear producto
            $venture->products()->create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $imagePath,
            ]);

            return redirect()->route('entrepreneur.emprendimientos.productos.index', $ventureId)
                ->with('swal_success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Error al crear el producto: ' . $e->getMessage());
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
    public function edit($ventureId, $id)
    {
        $entrepreneurId = Auth::user()->entrepreneur->id;

        $venture = Venture::where('id', $ventureId)
            ->where('entrepreneur_id', $entrepreneurId)
            ->firstOrFail();

        $product = $venture->products()->where('id', $id)->firstOrFail();

        return view('app.back.emprendedor.productos.edit-productos', compact('venture', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $ventureId, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:5120', // 5MB Max
        ]);

        try {
            $entrepreneurId = Auth::user()->entrepreneur->id;

            // Buscar el producto y verificar que pertenezca a un emprendimiento del usuario
            $product = Product::where('id', $id)
                ->whereHas('venture', function ($query) use ($entrepreneurId) {
                    $query->where('entrepreneur_id', $entrepreneurId);
                })
                ->firstOrFail();

            // Actualizar imagen si se proporciona una nueva
            if ($request->hasFile('image')) {
                // Eliminar imagen anterior
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                // Guardar nueva imagen
                $imagePath = $request->file('image')->store('products', 'public');
                $product->image = $imagePath;
            }

            // Actualizar datos
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->save();

            return redirect()->route('entrepreneur.emprendimientos.productos.index', $ventureId)->with('swal_success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ventureId, $id)
    {
        try {
            $entrepreneurId = Auth::user()->entrepreneur->id;

            // Buscar el producto verificando que pertenezca a un emprendimiento del usuario
            $product = Product::where('id', $id)
                ->whereHas('venture', function ($query) use ($entrepreneurId) {
                    $query->where('entrepreneur_id', $entrepreneurId);
                })
                ->firstOrFail();

            // Eliminar imagen si existe
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->back()->with('swal_success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('swal_error', 'Error al eliminado el producto: ' . $e->getMessage());
        }
    }
}
