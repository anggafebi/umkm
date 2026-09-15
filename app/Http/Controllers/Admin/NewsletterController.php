<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
class NewsletterController extends Controller
{
    public function index(){return view('admin.newsletter.index',['subscribers'=>NewsletterSubscriber::latest()->paginate(20)]);}
    public function export(){return response()->streamDownload(function(){ $o=fopen('php://output','w');fputcsv($o,['Email','Status','Source','Tanggal']);NewsletterSubscriber::latest()->chunk(500,function($rows)use($o){foreach($rows as $r)fputcsv($o,[$r->email,$r->status,$r->source,$r->created_at]);});fclose($o);},'newsletter-'.now()->format('Ymd-His').'.csv',['Content-Type'=>'text/csv']);}
    public function destroy(NewsletterSubscriber $subscriber){$subscriber->delete();return back()->with('success','Subscriber dihapus.');}
}
