<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogRecords;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class AdminLogsController extends Controller
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

        $log_data = LogRecords::paginate(10);

        return view('admin.log',compact('rol_name','rol_id',"log_data"));
    }
}
