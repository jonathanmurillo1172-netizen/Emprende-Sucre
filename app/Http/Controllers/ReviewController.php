<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    // Public: List reviews for a product (Paginated for AJAX)
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Paginate reviews (dynamic per page, default 100)
        $perPage = request()->input('per_page', 100);
        $reviews = $product->reviews()
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json($reviews);
    }

    // Public: Store a new review
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $normalizedEmail = strtolower(trim($request->email));

        // Check for duplicates
        $existingReview = Review::where('product_id', $request->product_id)
            ->whereRaw('LOWER(email) = ?', [$normalizedEmail])
            ->first();

        if ($existingReview) {
            return response()->json([
                'message' => 'Ya has enviado una reseña para este producto con este correo electrónico.'
            ], 422);
        }

        // Create review
        Review::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $normalizedEmail,
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => 'approved' // Default status
        ]);

        return response()->json(['message' => '¡Reseña enviada exitosamente!']);
    }

    // Entrepreneur: List all reviews for their products
    public function entrepreneurIndex()
    {
        $entrepreneur = Auth::user()->entrepreneur;

        if (!$entrepreneur) {
            abort(403);
        }

        // Get reviews for all products belonging to this entrepreneur's ventures
        $reviews = Review::whereHas('product.venture', function($query) use ($entrepreneur) {
            $query->where('entrepreneur_id', $entrepreneur->id);
        })
        ->with('product')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('app.back.emprendedor.reviews.index', compact('reviews'));
    }

    // Destroy: Entrepreneur or Admin can delete
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $user = Auth::user();

        $canDelete = false;

        if (Gate::allows('access-admin')) {
            $canDelete = true;
        } elseif (Gate::allows('access-entrepreneur')) {
            $product = $review->product;
            if ($product && $product->venture && $product->venture->entrepreneur_id == $user->entrepreneur->id) {
                $canDelete = true;
            }
        }

        if ($canDelete) {
            $review->delete();
            return back()->with('swal_success', 'Reseña eliminada correctamente.');
        }

        abort(403, 'No tienes permiso para eliminar esta reseña.');
    }
}
