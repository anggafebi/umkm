<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'email'=>'nullable|email',
            'message'=>'nullable'
        ]);

        $data['status']='new';

        Consultation::create($data);

        return back()->with(
            'success',
            'Konsultasi berhasil dikirim'
        );
    }
}