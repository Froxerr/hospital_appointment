<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentCapacity;
use App\Models\HospitalAppointment;
use App\Models\Pages;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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

        $occupancy_rate = $this->calculateAllOccupancy();
        $getNewUser = $this->getNewUser();
        $getAppointmentCount = $this->appointmentCount();
        $appointmentDatas = $this->getAppointmens();
        return view('admin.index',compact('rol_name','rol_id','occupancy_rate', 'getNewUser', 'getAppointmentCount', 'appointmentDatas'));
    }

    public function calculateAllOccupancy()
    {
        $now = now();
        $totalOccupancyRate = 0;
        $activeHospitals = 0;

        // Tüm hastaneleri ve kapasitelerini al
        $capacities = AppointmentCapacity::all();
        
        \Log::info('Toplam hastane kapasitesi sayısı: ' . $capacities->count());

        foreach ($capacities as $capacity) {
            // Her hastane için aktif randevu sayısını hesapla
            $activeAppointments = HospitalAppointment::where('hospital_address_id', $capacity->appointment_hospital_id)
                ->where('appointment_status', true)
                ->where('appointment_date_start', '>=', $now)
                ->count();

            \Log::info('Hastane ID: ' . $capacity->appointment_hospital_id . ' - Aktif Randevu: ' . $activeAppointments . ' - Max Kapasite: ' . $capacity->max_capacity);

            if ($capacity->max_capacity > 0) {
                // Doluluk oranını hesapla
                $occupancyRate = ($activeAppointments / $capacity->max_capacity) * 100;
                $totalOccupancyRate += $occupancyRate;
                $activeHospitals++;

                \Log::info('Hastane Doluluk Oranı: ' . $occupancyRate . '%');

                // Kapasiteyi güncelle
                $capacity->update([
                    'number_of_appointment' => $activeAppointments,
                    'available_capacity' => $capacity->max_capacity - $activeAppointments
                ]);
            }
        }

        // Ortalama doluluk oranını hesapla
        $averageOccupancyRate = $activeHospitals > 0 ? $totalOccupancyRate / $activeHospitals : 0;

        \Log::info('Toplam Doluluk: ' . $totalOccupancyRate . '% - Aktif Hastane: ' . $activeHospitals . ' - Ortalama: ' . $averageOccupancyRate . '%');

        return number_format($averageOccupancyRate, 2); // İki ondalık basamak göster
    }

    public function getNewUser()
    {
        $tenDays = Carbon::now()->subDays(10); //10'gün öncesini alıyor şu andan

        $usersCount = User::where('registration_date', '>=', $tenDays)->count(); //registration_date tablosundan 10 günlük aralığı say

        return $usersCount;
    }

    public function appointmentCount()
    {
        // Aktif (status=1) VE tarihi geçmemiş randevuları say
        $appointments = HospitalAppointment::where("appointment_status", '=', 1)
            ->where('appointment_date_start', '>=', Carbon::now())
            ->count();
        return $appointments;
    }

    public function getAppointmens()
    {
        $appointments = HospitalAppointment::with(['patient', 'doctor', 'hospitalAddress', 'floor', 'specialty'])
            ->orderBy('appointment_date_start', 'desc')
            ->get();

        $appointmentData = [];
        $id = 1;
        foreach ($appointments as $appointment)
        {
            $appointment_date_start = Carbon::parse($appointment->appointment_date_start);
            $is_past = $appointment_date_start->isPast();
            
            $status = match(true) {
                $is_past => 'Tamamlandı',
                $appointment->appointment_status === 1 => 'Onaylandı',
                $appointment->appointment_status === 0 => 'İptal',
                default => 'Beklemede'
            };
            
            $doctor_full_name = 'Dr. ' . $appointment->doctor->doctor_name . ' ' . $appointment->doctor->doctor_surname;
            $patient_full_name = $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname;
            $appointmentData[] = [
                'id' => $id,
                'patient_name' => $patient_full_name,
                'doctor_name' => $doctor_full_name,
                'appointment_date' => $appointment_date_start->format('Y-m-d H:i'),
                'status' => $status,
            ];
            $id++;
        }
        return $appointmentData;
    }
}
