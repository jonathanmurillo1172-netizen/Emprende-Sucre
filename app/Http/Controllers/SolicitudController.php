<?php

namespace App\Http\Controllers;

use App\Models\Venture;
use App\Models\Entrepreneur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the pending ventures.
     */
    public function index()
    {
        $pendingEntrepreneurs = Entrepreneur::with('user')
            ->whereNotNull('activation_requested_at')
            ->where('status', 'inactive')
            ->get();

        $ventures = Venture::where('status', 'inactive')
            ->where('title', 'not like', '[RECHAZADO]%')
            ->with(['category', 'entrepreneur.user'])
            ->withCount('products')
            ->paginate(10);

        return view('app.back.admin.solicitudes.solicitud', compact('ventures', 'pendingEntrepreneurs'));
    }

    /**
     * Approve the specified venture.
     */
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $venture = Venture::findOrFail($id);
            $venture->status = 'active';
            $venture->save();
            DB::commit();

            return redirect()->route('admin.validar.index')
                ->with('swal_success', 'Emprendimiento aprobado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('swal_error', 'Error al aprobar el emprendimiento: ' . $e->getMessage());
        }
    }

    /**
     * Disapprove (Reject) the specified venture.
     */
    public function disapprove(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $venture = Venture::findOrFail($id);
            
            // WORKAROUND: Como no se puede cambiar la DB y el enum status solo permite 'active'/'inactive'.
            // Marcamos como rechazado agregando prefijo al título y manteniendolo 'inactive'.
            if (!str_starts_with($venture->title, '[RECHAZADO] ')) {
                $venture->title = '[RECHAZADO] ' . $venture->title;
                // $venture->status = 'inactive'; // Se mantiene inactive
                $venture->save();
            }

            DB::commit();

            return redirect()->route('admin.validar.index')
                ->with('swal_success', 'Emprendimiento rechazado correctamente. El emprendedor podrá corregirlo.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('swal_error', 'Error al rechazar: ' . $e->getMessage());
        }
    }

    /**
     * Show the products for the specified venture.
     */
    public function showProducts($id)
    {
        $venture = Venture::with('products', 'category')->findOrFail($id);
        $products = $venture->products;

        return view('app.back.admin.solicitudes.producto-solicitudes', compact('venture', 'products'));
    }
    /**
     * Mark notifications as read (store in session).
     */
    public function markAsRead(Request $request)
    {
        $ids = $request->input('ids', []);
        $viewed = session()->get('viewed_notifications', []);
        
        $viewed = array_unique(array_merge($viewed, $ids));
        session()->put('viewed_notifications', $viewed);
        
        return response()->json(['status' => 'success']);
    }
}
