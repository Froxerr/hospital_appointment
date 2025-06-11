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

        try {
            \DB::beginTransaction();

            $user = User::find($user_id);

            if (!$user) {
                session()->flash('swal_message', 'Kullanıcı bulunamadı.');
                session()->flash('swal_type', 'error');
                return redirect()->back();
            }

            // Eski rol ID'sini sakla
            $oldRoleId = $user->role_id;

            // Kullanıcının rolünü güncelle
            $user->role_id = $role_id;
            $user->save();

            // Eğer yeni rol doktor (1) ise ve doctors tablosunda kaydı yoksa
            if ($role_id == 1) {
                $existingDoctor = \App\Models\Doctor::where('doctor_email', $user->email)->first();
                
                if (!$existingDoctor) {
                    $doctor = \App\Models\Doctor::create([
                        'doctor_name' => $user->name,
                        'doctor_surname' => $user->surname,
                        'doctor_email' => $user->email,
                        'doctor_phone' => $user->phone,
                        'specialties_id' => 1, // Varsayılan uzmanlık alanı
                        'address_id' => 1 // Varsayılan adres
                    ]);

                    // Doktor için bir yıllık çalışma saati oluştur
                    \App\Models\DoctorSchedule::create([
                        'doctor_id' => $doctor->doctor_id,
                        'work_time_start' => now()->setTime(9, 0), // 09:00
                        'work_time_end' => now()->addYear()->setTime(17, 0), // Bir yıl sonra 17:00
                        'status' => true
                    ]);
                }
            }

            \DB::commit();

            // Başarıyla güncellendi mesajı
            session()->flash("swal_message", "Rol başarıyla güncellendi.");
            session()->flash("swal_type", "success");

            return redirect()->back();

        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error("Rol güncelleme hatası: " . $e->getMessage());
            
            session()->flash('swal_message', 'Rol güncellenirken bir hata oluştu: ' . $e->getMessage());
            session()->flash('swal_type', 'error');
            
            return redirect()->back();
        }
    }
}
