<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AppointmentCapacity;
use App\Models\City;
use App\Models\District;
use App\Models\HospitalAppointment;
use App\Models\LogRecords;
use App\Models\Pages;
use App\Models\Patients;
use App\Models\Specialty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentUpdateController extends Controller
{
    public function index(Request $request)
    {

        // 'id' parametresinin var olup olmadığını kontrol et
        $appointment_id = $request->input('id');

        if (!$appointment_id) {
            // Eğer 'id' yoksa, kullanıcıyı 'appointment-show' sayfasına yönlendir
            return redirect("appointment-show");
        }

        // 'id' parametresi mevcutsa işlemlere devam et
        $appointmentData = HospitalAppointment::where('hospital_appointment_id', $appointment_id)->first();

        if (!$appointmentData) {
            // Eğer randevu bulunamazsa, kullanıcıyı 'appointment-show' sayfasına yönlendir
            return redirect("appointment-show");
        }

        $address_id = Address::where("address_id", $appointmentData->hospital_address_id)->first();
        $address_name = $address_id->address_name;
        $district = District::where("district_id", $address_id->address_district_id)->first();
        $district_id = $district->district_id;
        $city_id = $district->city_id;

        $appointmentDate = $appointmentData->appointment_date_start;
        $appointmentDate = Carbon::parse($appointmentDate)->format('Y-m-d');
        $appointmentTime = $appointmentData->appointment_date_start;
        $appointmentTime = Carbon::parse($appointmentTime)->format('H:i');

        $pagesData = Pages::all();
        $specialties = Specialty::all();
        $cities = City::all();

        if (Auth::check()) {
            $user = User::where('id', Auth::id())->first();
            $role_id = $user->role_id;

            return view('appointment.appointment_update', compact("appointmentData", "appointmentDate", "appointmentTime", "address_name", "city_id", "district_id", 'pagesData', 'role_id', 'specialties', 'cities'), ['showFooter' => false]);
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request, $appointmentId)
    {
        // Form verilerini doğrulama
        $validatedData = $request->validate([
            'category' => 'required',
            'sub_category' => 'required',
            'city' => 'required',
            'district' => 'required',
            'hospital' => 'required',
            'floor_id' => 'required',
            'doctor' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        // Kullanıcı bilgilerini al
        $userEmail = Auth::user()->email;
        $patient = Patients::where('patients_email', $userEmail)->first();
        $patientId = $patient->patients_id;

        // Hastane adresi bilgisi
        $hospitals = Address::where('address_district_id', $validatedData["district"])->get("address_id");
        foreach ($hospitals as $hospital) {
            $hospitalAddressId = $hospital->address_id;
        }

        // Gelen veriler
        $floorId = $validatedData["floor_id"];
        $doctorId = $validatedData["doctor"];
        $specialties_Id = $validatedData["sub_category"];
        $appointment_name = $validatedData["category"];
        $date = $validatedData["date"];
        $time = $validatedData["time"];

        // Randevu başlangıç ve bitiş saatlerini hesapla
        $appointment_date_start = Carbon::parse($date . ' ' . $time);
        $appointment_date_end = $appointment_date_start->copy()->addMinutes(30); // 30 dakika ekliyoruz
        $appointment_date_start = $appointment_date_start->format('Y-m-d H:i');
        $appointment_date_end = $appointment_date_end->format('Y-m-d H:i');
        $appointment_status = true;

        // Güncellenecek randevuyu bulma
        $appointment = HospitalAppointment::find($appointmentId);

        if (!$appointment) {
            session()->flash('swal_message', 'Randevu bulunamadı.');
            session()->flash('swal_type', 'error');
            return redirect('/appointment');
        }

        // Randevu verilerini güncelleme
        $appointment->update([
            'patient_id' => $patientId,
            'hospital_address_id' => $hospitalAddressId,
            'hospital_appointment_floor_id' => $floorId,
            'doctor_id' => $doctorId,
            'specialties_id' => $specialties_Id,
            'appointment_name' => $appointment_name,
            'appointment_date_start' => $appointment_date_start,
            'appointment_date_end' => $appointment_date_end,
            'appointment_status' => $appointment_status,
        ]);

        // Kapasiteyi kontrol et
        $capacity = AppointmentCapacity::where('appointment_hospital_id', $hospitalAddressId)->first();

        if ($capacity) {
            if ($capacity->available_capacity > 0) {
                // Kapasiteyi güncelleme
                $capacity->increment('number_of_appointment', 1);
                $capacity->decrement('available_capacity', 1);
            } else {
                // Eğer kapasite dolmuşsa, hata mesajı
                session()->flash('swal_message', 'Kapasite dolu. Randevu Güncellenemiyor.');
                session()->flash('swal_type', 'error');
                $this->logUserAction(Auth::user(), "Kapasite dolu. Randevu Güncellenemiyor.", "warning");
                return redirect('/appointment');
            }
        } else {
            // Kapasite bilgisi bulunamadıysa
            session()->flash('swal_message', 'Bu hastane için kapasite bilgisi bulunamadı.');
            session()->flash('swal_type', 'error');
            $this->logUserAction(Auth::user(), "Bu hastane için kapasite bilgisi bulunamadı.", "warning");
            return redirect('/appointment');
        }

        $this->logUserAction(Auth::user(), "Randevunuz Başarıyla Güncellenmiştir.");
        session()->flash("swal_message", "Randevunuz Başarıyla Güncellenmiştir.");
        session()->flash("swal_type", "success");

        return redirect('/appointment');
    }
    private function logUserAction($user, $description, $badge = 'info')
    {
        LogRecords::create([
            'user_id' => $user->id,
            'log_description' => $description,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'badge' => $badge,
            'ip_address' => request()->ip(),  // Kullanıcının IP adresi
        ]);
    }

}
