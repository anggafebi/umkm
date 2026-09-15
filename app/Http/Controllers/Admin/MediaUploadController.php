<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class MediaUploadController extends Controller
{
    public function index(){ $files=collect(Storage::disk('public')->files('uploads'))->sortDesc(); return view('admin.media.upload',compact('files')); }
    public function upload(Request $request){ $request->validate(['image'=>'required|image|max:4096']); $path=$request->file('image')->store('uploads','public'); return back()->with(['success'=>'File berhasil diupload.','path'=>'storage/'.$path]); }
    public function destroy(Request $request){ $data=$request->validate(['path'=>'required|string']); if(str_starts_with($data['path'],'uploads/')) Storage::disk('public')->delete($data['path']); return back()->with('success','Media dihapus.'); }
}
