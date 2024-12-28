<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalAppointment;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminAppointmentController extends Controller
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

        $data = $this->getAppointmens();
        return view('admin.appointment', [
            'rol_name' => $rol_name,
            'rol_id' => $rol_id,
            'appointmentData' => $data['appointmentData'],
            'appointments' => $data['appointments'],
        ]);
    }

    public function getAppointmens()
    {
        $appointments = HospitalAppointment::with(['patient', 'doctor', 'hospitalAddress', 'floor', 'specialty'])
            ->paginate(10); // Sayfalama burada yapılır

        $appointmentData = collect();  // Koleksiyon oluşturuluyor
        $idOffset = ($appointments->currentPage() - 1) * $appointments->perPage() + 1;

        foreach ($appointments as $appointment) {
            $status = $appointment->appointment_status ? 'Onaylandı' : 'İptal';
            $appointment_date_start = Carbon::parse($appointment->appointment_date_start);
            $doctor_full_name = 'Dr. ' . $appointment->doctor->doctor_name . ' ' . $appointment->doctor->doctor_surname;
            $patient_full_name = $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname;

            $appointmentData->push((object) [
                'id' => $idOffset++,
                'patient_name' => $patient_full_name,
                'doctor_name' => $doctor_full_name,
                'appointment_date' => $appointment_date_start->format('Y-m-d H:i'),
                'status' => $status,
            ]);
        }

        // View'a appointmentData ve paginator'ı birlikte göndereceğiz
        return [
            'appointmentData' => $appointmentData,
            'appointments' => $appointments,  // Paginator'ı da gönderiyoruz
        ];
    }

}
