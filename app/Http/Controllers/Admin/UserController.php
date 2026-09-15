<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){ abort_unless(auth()->user()->role === 'admin', 403); return view('admin.users.index',['users'=>User::latest()->get()]); }
    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        $data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email','password'=>'required|min:8','role'=>'required|in:admin,editor']);
        $data['password']=Hash::make($data['password']); User::create($data);
        ActivityLog::create(['user_id'=>auth()->id(),'action'=>'user.created','description'=>'Akun admin/editor dibuat','ip_address'=>$request->ip()]);
        return back()->with('success','Pengguna berhasil dibuat.');
    }
    public function update(Request $request, User $user)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        $data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email,'.$user->id,'password'=>'nullable|min:8','role'=>'required|in:admin,editor']);
        if(empty($data['password'])) unset($data['password']); else $data['password']=Hash::make($data['password']);
        $user->update($data); return back()->with('success','Pengguna diperbarui.');
    }

    public function profile(){ return view('admin.profile.index',['user'=>auth()->user()]); }
    public function updateProfile(Request $request)
    {
        $user=auth()->user();
        $data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email,'.$user->id,'password'=>'nullable|min:8']);
        if(empty($data['password'])) unset($data['password']); else $data['password']=Hash::make($data['password']);
        $user->update($data); return back()->with('success','Profil berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        if($user->id===auth()->id()) return back()->withErrors(['user'=>'Akun yang sedang digunakan tidak dapat dihapus.']);
        $user->delete(); return back()->with('success','Pengguna dihapus.');
    }
}
