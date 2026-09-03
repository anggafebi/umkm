<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::latest()->paginate(10);

        return view('admin.consultations.index', compact('consultations'));
    }

    public function update(Request $request, $id)
    {
        $consultation = Consultation::findOrFail($id);

        $consultation->update([
            'status' => $request->status
        ]);

        return back();
    }
}