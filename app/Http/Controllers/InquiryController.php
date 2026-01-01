<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $entrepreneur = Auth::user()->entrepreneur;
        
        if (!$entrepreneur) {
            return redirect()->route('home');
        }

        $filter = $request->get('filter', 'pending'); // pending or attended

        $inquiries = Inquiry::whereIn('venture_id', $entrepreneur->ventures->pluck('id'))
            ->where('attended', $filter === 'attended')
            ->with('venture')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('app.back.emprendedor.consultas.index', compact('inquiries', 'filter'));
    }

    public function toggleStatus($id)
    {
        $entrepreneur = Auth::user()->entrepreneur;
        $inquiry = Inquiry::findOrFail($id);

        if (!$entrepreneur->ventures->contains('id', $inquiry->venture_id)) {
            abort(403);
        }

        $inquiry->attended = !$inquiry->attended;
        $inquiry->save();

        $message = $inquiry->attended ? 'Marcado como atendido.' : 'Marcado como pendiente.';
        return back()->with('swal_success', $message);
    }

    public function destroy($id)
    {
        $entrepreneur = Auth::user()->entrepreneur;
        $inquiry = Inquiry::findOrFail($id);

        // Verificar que la consulta pertenece a uno de sus emprendimientos
        if (!$entrepreneur->ventures->contains('id', $inquiry->venture_id)) {
            abort(403);
        }

        $inquiry->delete();

        return back()->with('swal_success', 'Consulta eliminada correctamente.');
    }
}
