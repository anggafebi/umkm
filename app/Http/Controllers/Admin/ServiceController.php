<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'slug'=>'required'
        ]);

        Service::create($data);

        return back();
    }

    public function destroy($id)
    {
        Service::findOrFail($id)->delete();

        return back();
    }
}