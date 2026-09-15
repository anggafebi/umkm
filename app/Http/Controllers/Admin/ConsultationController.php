<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $consultations=Consultation::query()
            ->when($request->filled('status'),fn($q)=>$q->where('status',$request->status))
            ->when($request->filled('q'),fn($q)=>$q->where(function($x) use($request){$x->where('name','like','%'.$request->q.'%')->orWhere('business_name','like','%'.$request->q.'%')->orWhere('phone','like','%'.$request->q.'%');}))
            ->latest()->paginate(15)->withQueryString();
        return view('admin.consultations.index',compact('consultations'));
    }
    public function update(Request $request, Consultation $consultation)
    {
        $data=$request->validate(['status'=>'required|in:new,contacted,follow_up,deal,closed','admin_notes'=>'nullable|string|max:3000']);
        if($data['status']!=='new') $data['last_contacted_at']=now();
        $consultation->update($data);
        ActivityLog::create(['user_id'=>auth()->id(),'action'=>'lead.updated','description'=>"Lead {$consultation->name} diubah ke {$data['status']}",'ip_address'=>$request->ip()]);
        return back()->with('success','Status lead diperbarui.');
    }
    public function export()
    {
        $filename='leads-'.now()->format('Ymd-His').'.csv';
        return response()->streamDownload(function(){
            $out=fopen('php://output','w'); fputcsv($out,['Nama','Bisnis','Telepon','Email','Minat','Budget','Status','Tanggal']);
            Consultation::latest()->chunk(200,function($rows) use($out){foreach($rows as $r) fputcsv($out,[$r->name,$r->business_name,$r->phone,$r->email,$r->service_interest,$r->budget,$r->status,$r->created_at]);});
            fclose($out);
        },$filename,['Content-Type'=>'text/csv']);
    }
}
