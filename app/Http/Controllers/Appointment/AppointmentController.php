<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AppointmentCapacity;
use App\Models\City;
use App\Models\HospitalAppointment;
use App\Models\LogRecords;
use App\Models\Pages;
use App\Models\Patients;
use App\Models\Specialty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $pagesData = Pages::all();
        $specialties = Specialty::all();
        $cities = City::all();
        if(Auth::check())
        {
            Auth::id();

            $user = User::where('id', Auth::id())->first();
            $role_id = $user->role_id;
            return view('appointment.index', compact('pagesData','role_id','specialties','cities'),['showFooter' => false]);
        }
        else
        {
            return redirect('/');
        }
    }
    public function store(Request $request)
    {
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
        //patient_id'sine ulaşma işlemleri
        $userEmail = Auth::user()->email;
        $patient = Patients::where('patients_email', $userEmail)->first();
        $patientId = $patient->patients_id;

        //Hastane adres id'si
        $hospitals = Address::where('address_district_id', $validatedData["district"])->get("address_id");
        foreach ($hospitals as $hospital) {
            $hospitalAddressId = $hospital->address_id;
        }

        //validate'den gelen değerler
        $floorId = $validatedData["floor_id"];
        $doctorId = $validatedData["doctor"];
        $specialties_Id = $validatedData["sub_category"];
        $appointment_name = $validatedData["category"];
        $date = $validatedData["date"];
        $time = $validatedData["time"];

        $appointment_date_start = Carbon::parse($date . ' ' . $time);
        $appointment_date_end = $appointment_date_start->copy()->addMinutes(30); // 'copy' ile orijinalini değiştirmeden yeni bir nesne oluşturup end yapıyoruz
        $appointment_date_start = $appointment_date_start->format('Y-m-d H:i'); //format değiştirmek zorunlu değil ama ben değiştirdim
        $appointment_date_end = $appointment_date_end->format('Y-m-d H:i');
        $appointment_status = true;


        $appointmentsData = [
            'patient_id' => $patientId,
            'hospital_address_id' => $hospitalAddressId,
            'hospital_appointment_floor_id' => $floorId,
            'doctor_id' => $doctorId,
            'specialties_id' => $specialties_Id,
            'appointment_name' => $appointment_name,
            'appointment_date_start' => $appointment_date_start,
            'appointment_date_end' => $appointment_date_end,
            'appointment_status' => $appointment_status,
        ];
        HospitalAppointment::create($appointmentsData);


        $capacity = AppointmentCapacity::where('appointment_hospital_id', $hospitalAddressId)->first();
        // Eğer kapasite verisi bulunursa, güncelleme işlemi
        if ($capacity) {
            if ($capacity->available_capacity > 0) { //eğer hala bir yer varsa
                // Kapasiteyi güncelleme
                $capacity->increment('number_of_appointment', 1); // number_of_appointment'ı bir artır
                $capacity->decrement('available_capacity', 1); // available_capacity'yi bir azalt
            } else {
                // Eğer kapasite 0 ise, hata mesajı
                session()->flash('swal_message', 'Kapasite dolu. Randevu alınamıyor.');
                session()->flash('swal_type', 'error');
                $this->logUserAction(Auth::user(),"Kapasite dolu. Randevu alınamıyor.","warning");
                return redirect('/appointment');
            }
        } else {
            // Eğer uygun bir kapasite kaydı bulunamazsa
            session()->flash('swal_message', 'Bu hastane için kapasite bilgisi bulunamadı.');
            session()->flash('swal_type', 'error');
            $this->logUserAction(Auth::user(),"Bu hastane için kapasite bilgisi bulunamadı.","warning");
            return redirect('/appointment');
        }


        $this->logUserAction(Auth::user(),"Randevunuz Başarılı Şekilde Oluşturulmuştur.");
        session()->flash("swal_message","Randevunuz Başarılı Şekilde Oluşturulmuştur.");
        session()->flash("swal_type","success");


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
