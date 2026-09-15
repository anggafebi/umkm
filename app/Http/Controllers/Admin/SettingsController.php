<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
        $data = $request->validate(['settings'=>'required|array']);
        foreach ($data['settings'] as $key => $value) {
            Setting::where('key',$key)->update(['value'=>is_array($value)?json_encode($value):$value]);
        }
        Cache::forget('site_settings');
        ActivityLog::create(['user_id'=>auth()->id(),'action'=>'settings.updated','description'=>'Pengaturan website diperbarui','ip_address'=>$request->ip()]);
        return back()->with('success','Pengaturan berhasil disimpan.');
    }
}
