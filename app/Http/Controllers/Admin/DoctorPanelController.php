<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\HospitalAppointment;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DoctorPanelController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            Log::info('DoctorPanel: Kullanıcı giriş yapmamış');
            return redirect('/');
        }

        $user = Auth::user();
        Log::info('DoctorPanel: Kullanıcı bilgileri', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role_id' => $user->role_id
        ]);

        $role = Role::where('role_id', $user->role_id)->first();

        if (!$role) {
            Log::warning('DoctorPanel: Rol bulunamadı', ['user_id' => $user->id]);
            return redirect('/');
        }

        $rol_name = $role->role_name;
        $rol_id = $role->role_id;

        Log::info('DoctorPanel: Rol bilgileri', [
            'rol_name' => $rol_name,
            'rol_id' => $rol_id
        ]);

        // Sadece doktor (1) ve admin (4) rollerine izin ver
        if ($rol_id == 1) {
            $doctor = Doctor::where('doctor_email', $user->email)->first();

            if (!$doctor) {
                Log::error('DoctorPanel: Doktor kaydı bulunamadı', [
                    'user_email' => $user->email
                ]);
                session()->flash('error', 'Doktor kaydı bulunamadı.');
                return redirect('/');
            }

            Log::info('DoctorPanel: Doktor bilgileri', [
                'doctor_id' => $doctor->doctor_id,
                'doctor_email' => $doctor->doctor_email
            ]);

            $doctorData = $this->getAppointments($doctor->doctor_id);
        } elseif ($rol_id == 4) {
            $doctorData = $this->getAllAppointments();
        } else {
            Log::warning('DoctorPanel: Yetkisiz rol', ['rol_id' => $rol_id]);
            return redirect('/');
        }

        Log::info('DoctorPanel: Randevu sayısı', [
            'count' => count($doctorData),
            'role' => $rol_id == 1 ? 'doctor' : 'admin'
        ]);

        return view('admin.doctor_panel', compact('rol_name', 'rol_id', 'doctorData'));
    }

    private function getAppointments($doctor_id)
    {
        $appointments = HospitalAppointment::with(['patient', 'hospitalAddress', 'floor', 'specialty'])
            ->where('doctor_id', $doctor_id)
            ->orderBy('appointment_date_start', 'desc')
            ->get();

        Log::info('DoctorPanel: Doktor randevuları', [
            'doctor_id' => $doctor_id,
            'count' => $appointments->count()
        ]);

        if ($appointments->isEmpty()) {
            Log::warning('DoctorPanel: Doktora ait randevu bulunamadı', [
                'doctor_id' => $doctor_id
            ]);
        }

        return $appointments->map(function ($appointment) {
            try {
                return [
                    'id' => $appointment->hospital_appointment_id,
                    'patient_name' => $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname,
                    'date' => Carbon::parse($appointment->appointment_date_start)->format('d.m.Y'),
                    'time' => Carbon::parse($appointment->appointment_date_start)->format('H:i'),
                    'location' => $appointment->hospitalAddress->address_name . ' - ' . $appointment->floor->floor_name,
                    'specialty' => $appointment->specialty->specialty_name,
                    'status' => $appointment->appointment_status ? 'Onaylandı' : 'İptal'
                ];
            } catch (\Exception $e) {
                Log::error('DoctorPanel: Randevu verisi dönüştürme hatası', [
                    'appointment_id' => $appointment->hospital_appointment_id,
                    'error' => $e->getMessage()
                ]);
                return null;
            }
        })->filter();
    }

    private function getAllAppointments()
    {
        $appointments = HospitalAppointment::with(['patient', 'doctor', 'hospitalAddress', 'floor', 'specialty'])
            ->orderBy('appointment_date_start', 'desc')
            ->get();

        Log::info('DoctorPanel: Tüm randevular', [
            'count' => $appointments->count()
        ]);

        if ($appointments->isEmpty()) {
            Log::warning('DoctorPanel: Hiç randevu bulunamadı');
        }

        return $appointments->map(function ($appointment) {
            try {
                return [
                    'id' => $appointment->hospital_appointment_id,
                    'patient_name' => $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname,
                    'doctor_name' => 'Dr. ' . $appointment->doctor->doctor_name . ' ' . $appointment->doctor->doctor_surname,
                    'date' => Carbon::parse($appointment->appointment_date_start)->format('d.m.Y'),
                    'time' => Carbon::parse($appointment->appointment_date_start)->format('H:i'),
                    'location' => $appointment->hospitalAddress->address_name . ' - ' . $appointment->floor->floor_name,
                    'specialty' => $appointment->specialty->specialty_name,
                    'status' => $appointment->appointment_status ? 'Onaylandı' : 'İptal'
                ];
            } catch (\Exception $e) {
                Log::error('DoctorPanel: Randevu verisi dönüştürme hatası', [
                    'appointment_id' => $appointment->hospital_appointment_id,
                    'error' => $e->getMessage()
                ]);
                return null;
            }
        })->filter();
    }
}
