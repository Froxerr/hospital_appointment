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

    public function calculateAllOccupancy() //Tüm doluluk oranı
    { //(number_of_appointment / max_capacity) * 100
        $capacities = AppointmentCapacity::all();
        $totalOccupancyRate = 0;

        foreach ($capacities as $capacity) {
            $number_of_appointments = $capacity->number_of_appointment;
            $max_capacity = $capacity->max_capacity;

            // Doluluk oranını (Yüzde cinsinden)
            $occupancyRate = ($max_capacity > 0) ? ($number_of_appointments / $max_capacity) * 100 : 0;

            // Toplam doluluk oranını güncelleyelim
            $totalOccupancyRate += $occupancyRate;
        }
        // Toplam doluluk oranını, hastane sayısına bölerek ortalama doluluk oranını
        $averageOccupancyRate = count($capacities) > 0 ? $totalOccupancyRate / count($capacities) : 0;

        return (int)$averageOccupancyRate;
    }

    public function getNewUser()
    {
        $tenDays = Carbon::now()->subDays(10); //10'gün öncesini alıyor şu andan

        $usersCount = User::where('registration_date', '>=', $tenDays)->count(); //registration_date tablosundan 10 günlük aralığı say

        return $usersCount;
    }

    public function appointmentCount()
    {
        $appointments = HospitalAppointment::where("appointment_status", '=', true)->count();
        return $appointments;
    }

    public function getAppointmens()
    {
        $appointments = HospitalAppointment::with(['patient', 'doctor', 'hospitalAddress', 'floor', 'specialty'])
            //->latest() //en son eklenenleri | Bu fonksiyon hata veriyor çünkü created at üzerinden işlem yapıyor ama o bende yok
            ->orderBy('appointment_date_start', 'desc')
            ->limit(10) //10 tane ile sınırla
            ->get(); //hepsini getir

        $appointmentData = [];
        $id = 1;
        foreach ($appointments as $appointment)
        {
            $status = $appointment->appointment_status ? 'Onaylandı' : 'İptal';
            $appointment_date_start = Carbon::parse($appointment->appointment_date_start);
            $doctor_full_name = 'Dr. ' . $appointment->doctor->doctor_name . ' ' . $appointment->doctor->doctor_surname;
            $patient_full_name = $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname;
            $appointmentData[] = [
                'id' => $id,
                'patient_name' => $patient_full_name, // Hasta adı
                'doctor_name' => $doctor_full_name, // Doktor adı
                'appointment_date' => $appointment_date_start->format('Y-m-d H:i'), // Randevu tarihi
                'status' => $status, // Randevu durumu
            ];
            $id++;
        }
        return $appointmentData;
    }
}
