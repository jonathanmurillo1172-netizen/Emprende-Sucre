<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Venture;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Venture::where('status', 'active')
            ->whereHas('entrepreneur', function ($q) {
                $q->where('status', 'active');
            })
            ->with(['category', 'entrepreneur.user']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $ventures = $query->orderBy('created_at', 'desc')->paginate(9);
        
        // Get all categories for the filter
        $categories = Category::orderBy('name')->get();

        return view('app.front.index', compact('ventures', 'categories'));
    }

    public function showProducts($id)
    {
        $venture = Venture::where('status', 'active')
            ->whereHas('entrepreneur', function ($q) {
                $q->where('status', 'active');
            })
            ->findOrFail($id);
        $products = $venture->products()->withAvg('reviews', 'rating')->where('status', 'active')->orderBy('created_at', 'desc')->paginate(12);

        return view('app.front.products', compact('venture', 'products'));
    }

    public function storeInquiry(Request $request)
    {
        $request->validate([
            'venture_id' => 'required|exists:ventures,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Inquiry::create($request->all());

        return back()->with('swal_success', 'El emprendedor se comunicará al contacto proporcionado.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
