<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\HospitalAppointment;
use App\Models\Pages;
use App\Models\Patients;
use App\Models\Specialty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentShowController extends Controller
{
    public function index(Request $request)
    {
        $pagesData = Pages::all();
        $userEmail = Auth::user()->email;
        $patient = Patients::where('patients_email', $userEmail)->first();

        if ($patient) {
            $patientId = $patient->patients_id;
            $appointmentsCheck = HospitalAppointment::where('patient_id', $patientId)->get();

            if ($appointmentsCheck->isEmpty()) {
                session()->flash('message', 'Henüz bir randevunuz yok.');
            }
        } else {
            $patientId = null;
            session(['message' => 'Bir hata oluştu. Lütfen tekrar deneyin.']);
        }

        if(Auth::check()) {
            // getAppointments'dan dönen array'i collection'a çevir
            $appointmentsGetData = collect($this->getAppointments($patientId, $request));
            
            $user = User::where('id', Auth::id())->first();
            $role_id = $user->role_id;
            $specialties = Specialty::all();

            // Collection boş mu kontrolü
            $isEmpty = $appointmentsGetData->isEmpty();
            
            return view('appointment.appointment_show', 
                compact('pagesData', 'role_id', 'appointmentsGetData', 'specialties', 'isEmpty'),
                ['showFooter' => false]
            );
        } else {
            return redirect('/');
        }
    }
    public function getAppointments($patientId, Request $request)
    {
        //ihtiyaclar = -Poliklinik Adı- | -Tarih- | -Saat- | Hastane Adı |  Hastan Adresi | Hastane Katı | Doktor Adı | -Status- | Randevu id
        // Randevu bilgilerini, ilişkilerle birlikte çekiyoruz.
        $query = HospitalAppointment::with(['patient', 'doctor', 'hospitalAddress', 'floor', 'specialty'])
            ->where('patient_id',$patientId) // Kullanıcının ID'sine göre filtreleme
            ->orderBy('appointment_date_start', 'asc'); // Randevu tarihine göre artan sırayla sıralama

        // Filtreleri uygulama
        if ($request->filled('start_date')) {
            $query->where('appointment_date_start', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('appointment_date_start', '<=', $request->end_date . ' 23:59:59'); // Gün sonuna kadar
        }

        if ($request->filled('status')) {
            if ($request->status == 'Aktif') {
                $query->where('appointment_status', true)->where('appointment_date_start', '>=', Carbon::now());
                
            } elseif ($request->status == 'İptal') {
                $query->where('appointment_status', false);
            } elseif ($request->status == 'Tamamlandı') {
                $query->where('appointment_status', true)->where('appointment_date_start', '<=', Carbon::now());
            }
        }

        if ($request->filled('policlinic')) {
            $query->where('specialties_id', $request->policlinic);
        }
    

        $appointments = $query->get(); // Veritabanından verileri alıyoruz

        $appointmentData = [];

        foreach ($appointments as $appointment) {
            // Randevu durumu: Onaylı veya İptal
            $status = $appointment->appointment_status ? 'Onaylandı' : 'İptal';

            // 'Tamamlandı' durumu için ek kontrol (eğer aktifse ve tarihi geçmişse)
            if ($status == 'Onaylandı' && Carbon::parse($appointment->appointment_date_start)->isPast()) {
                $status = 'Tamamlandı';
            }

            // Poliklinik adı
            $policlinic_name = $appointment->specialty->specialty_name;

            // Randevu tarihi ve saatini formatlıyoruz
            $appointment_date = Carbon::parse($appointment->appointment_date_start);
            $appointment_date_formatted = $appointment_date->format('Y-m-d');
            $appointment_time = $appointment_date->format('H:i');
            $hospital_id = $appointment->hospital_appointment_id;

            // Hastane adı

            $hospital_name = $appointment->hospitalAddress->address_name;

            // Hastane Adresi

            $hospital_neighborhood = $appointment->hospitalAddress->address_neighborhood;
            $address_district_id = $appointment->hospitalAddress->address_district_id; //şehir ilçe ve mahalle birleşimi olacak
            $district = District::where('district_id', $address_district_id)->first();
            $district_name = $district->district_name;
            $city = City::where('city_id', $district->district_id)->first(); // Bu satırda hata olabilir, district_id yerine city_id kullanmalısınız
            $city_name = $city ? $city->city_name : ''; // Null kontrolü ekledim

            $hospital_address = $city_name ." ". $district_name .", ". $hospital_neighborhood;



            // Hastane katı
            $floor_block = $appointment->floor->hospital_block_name;
            $floor_floor_number = $appointment->floor->hospital_floor_number;
            $floor_room_number = $appointment->floor->hospital_room_number;
            $floor_name = $floor_block . ', ' . $floor_floor_number . '. Kat, '. $floor_room_number . ". Oda";

            // Doktor adı
            $doctor_full_name = 'Dr. ' . $appointment->doctor->doctor_name . ' ' . $appointment->doctor->doctor_surname;

            // Hasta adı
            $patient_full_name = $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname;

            // Randevu verilerini oluşturuyoruz
            $appointmentData[] = [
                'id' => $hospital_id,
                'patient_name' => $patient_full_name, // Hasta adı
                'doctor_name' => $doctor_full_name, // Doktor adı
                'appointment_date' => $appointment_date_formatted, // Randevu tarihi
                'status' => $status, // Randevu durumu
                'policlinic_name' => $policlinic_name, // Poliklinik adı
                'appointment_time' => $appointment_time, // Randevu saati
                'hospital_name' => $hospital_name, // Hastane adı
                'hospital_address' => $hospital_address, // Hastane adresi
                'floor_name' => $floor_name, // Hastane katı
            ];
        }

        return $appointmentData; // Randevuları döndürüyoruz
    }

    public function update(Request $request)
    {
        $appointment = HospitalAppointment::findOrFail($request->appointment_id);

        $appointment->update(['appointment_status' => 0]);

        session()->flash("swal_message","Randevunuz Başarıyla İptal Edildi.");
        session()->flash("swal_type","success");

        return redirect('appointment-show');
    }
}
