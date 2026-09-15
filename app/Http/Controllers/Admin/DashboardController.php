<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog; use App\Models\BlogPost; use App\Models\Consultation; use App\Models\NewsletterSubscriber; use App\Models\PageView; use App\Models\Portfolio; use App\Models\Product; use App\Models\Service;
class DashboardController extends Controller
{
    public function index()
    {
        $leadByStatus=Consultation::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total','status');
        $monthly=Consultation::where('created_at','>=',now()->subMonths(5)->startOfMonth())->get(['created_at'])->groupBy(fn($x)=>$x->created_at->format('Y-m'))->map->count()->sortKeys();
        return view('admin.dashboard',[
            'serviceCount'=>Service::count(),'productCount'=>Product::count(),'portfolioCount'=>Portfolio::count(),'consultationCount'=>Consultation::count(),'newLeadCount'=>Consultation::where('status','new')->count(),'blogCount'=>BlogPost::count(),
            'visitorCount'=>PageView::where('created_at','>=',now()->startOfMonth())->distinct('session_hash')->count('session_hash'),'pageViewCount'=>PageView::whereDate('created_at',today())->count(),'newsletterCount'=>NewsletterSubscriber::where('status','active')->count(),
            'leadByStatus'=>$leadByStatus,'monthlyLeads'=>$monthly,'recentLeads'=>Consultation::latest()->take(6)->get(),'activityLogs'=>ActivityLog::with('user')->latest()->take(8)->get()
        ]);
    }
}
