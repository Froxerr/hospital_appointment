<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\HospitalAppointment;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DoctorPanelController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role_id == 4)
        {
            $role = Role::where("role_id", Auth::user()->role_id)->first();
            $rol_name = $role->role_name;
            $rol_id = $role->role_id;

        }
        else if (Auth::check() && Auth::user()->role_id == 1)
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
        $doctor_email = Auth::user()->email;
        $doctor = Doctor::where("doctor_email", $doctor_email)->first();

        if (!$doctor) {
            return redirect('/'); // Yönlendirme anasayfaya
        }

        $doctor_id = $doctor->doctor_id;
        $doctorData = $this->getAppointmens($doctor_id);
        return view("admin.doctor_panel",compact('rol_name','doctorData','rol_id'));
    }
    public function getAppointmens($doctor_id)
    {
        // Randevuları sorgulayıp, paginated olarak alıyoruz
        $appointments = HospitalAppointment::with(['patient', 'doctor', 'hospitalAddress', 'floor', 'specialty'])
            ->where("doctor_id", $doctor_id)
            ->paginate(10); // Pagination burada

        // Her bir randevuyu dönüştürerek formatlıyoruz
        $appointments->getCollection()->transform(function($appointment) {
            $appointment_date = Carbon::parse($appointment->appointment_date_start);
            $appointment_time = Carbon::parse($appointment->appointment_date_start);

            return (object) [
                'id' => $appointment->hospital_appointment_id,
                'patient_name' => $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname,
                'appointment_date' => $appointment_date->format('d-m-Y'),
                'appointment_time' => $appointment_time->format('H:i'),
                'status' => $appointment->appointment_status ? 'Onaylandı' : 'İptal',
            ];
        });

        // Paginated veriyi direkt döndürüyoruz
        return $appointments;
    }
}
