<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Venture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminVentureController extends Controller
{
    /**
     * Display a listing of approved (active) ventures.
     */
    public function index()
    {
        $ventures = Venture::whereIn('status', ['active', 'disabled'])
            ->with(['entrepreneur.user', 'category'])
            ->withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('app.back.admin.emprendimientos.emprendimientos-aprobados', compact('ventures'));
    }

    /**
     * Show the products for the specified venture.
     */
    public function showProducts($id)
    {
        $venture = Venture::with('products', 'category')->findOrFail($id);
        $products = $venture->products;

        return view('app.back.admin.emprendimientos.productos-emprendimientos', compact('venture', 'products'));
    }

    /**
     * Alternar el estado de un emprendimiento.
     */
    public function toggleVentureStatus($id)
    {
        try {
            $venture = Venture::findOrFail($id);
            $newStatus = ($venture->status === 'active') ? 'disabled' : 'active';
            $venture->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Estado del emprendimiento actualizado correctamente.',
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Alternar el estado de un producto.
     */
    public function toggleProductStatus($id)
    {
        try {
            $product = Product::findOrFail($id);
            $newStatus = ($product->status === 'active') ? 'disabled' : 'active';
            $product->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Estado del producto actualizado correctamente.',
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified venture from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $venture = Venture::findOrFail($id);

            // Delete venture image
            if ($venture->image) {
                Storage::disk('public')->delete($venture->image);
            }

            // Delete associated products and their images
            foreach ($venture->products as $product) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->delete();
            }

            $venture->delete();
            DB::commit();

            return redirect()->route('admin.emprendimientos.index')
                ->with('swal_success', 'Emprendimiento eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('swal_error', 'Error al eliminar el emprendimiento: ' . $e->getMessage());
        }
    }
}
