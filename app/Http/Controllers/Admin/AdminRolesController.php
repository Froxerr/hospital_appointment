<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRolesController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role_id == 4)
        {
            $role_name = Role::where("role_id",Auth::user()->role_id)->get();
            foreach ($role_name as $role)
            {
                $rol_name = $role->role_name;
                $rol_id = $role->role_id;
            }
        }
        else
        {
            return redirect('/');
        }

        $users = User::paginate(10);
        $rolesDatas = Role::all();
        return view('admin.roles', compact('rol_name','rol_id','rolesDatas', 'users'));
    }

    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $role_id = $request->role_id;

        $user = User::find($user_id);

        if ($user) {
            $user->role_id = $role_id;
            $user->save();

            // Başarıyla güncellendi mesajı
            session()->flash("swal_message","Rol başarıyla güncellendi.");
            session()->flash("swal_type","success");

            return redirect()->back();
        }

        // Kullanıcı bulunamazsa hata mesajı
        session()->flash('swal_message', 'Kullanıcı bulunamadı.');
        session()->flash('swal_type', 'error');
        return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');

    }
}
