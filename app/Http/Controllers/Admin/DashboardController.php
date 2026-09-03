<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Product;
use App\Models\Portfolio;
use App\Models\Consultation;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'serviceCount' => Service::count(),
            'productCount' => Product::count(),
            'portfolioCount' => Portfolio::count(),
            'consultationCount' => Consultation::count(),
        ]);
    }
}