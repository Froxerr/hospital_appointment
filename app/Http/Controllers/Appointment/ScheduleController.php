<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\DoctorTimeOff;
use App\Models\HospitalAppointment;
use App\Models\LogRecords;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function getSchedule(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $date = $request->input('date'); //00-00-00 olarak geliyor
        $workDay = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'); //gelen değeri de uygun formata çeviriyoruz
        $workEndDay = Carbon::createFromFormat('Y-m-d', $workDay)->addDays(1)->format('Y-m-d');

        // Doktorun takvimindeki programları ve randevuları alıyoruz
        $schedules = DoctorSchedule::where('doctor_id', $doctorId)
            ->whereDate('work_time_start', '<=', $workDay)
                ->whereDate('work_time_end', '>=', $workEndDay)
            ->get();
        $appointments = HospitalAppointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date_start', $workDay)
            ->get();

        // Doktorun tatil günü olup olmadığını kontrol ediyoruz
        $timeOff = DoctorTimeOff::where('doctor_id', $doctorId)
            ->whereDate('time_off_date_start', '<=', $workDay)
            ->whereDate('time_off_date_end', '>=', $workEndDay)
            ->where('time_off_status', true)  // tatil durumu aktif olmalı
            ->exists(); // Bu tarih tatil gününe denk geliyor mu?

        if ($timeOff) {
            $this->logUserAction(Auth::user(),"Doktor bu ".$date." tarihte tatilde.", "danger");
            // Sadece mesaj döndürüyoruz
            return response()->json([
                'message' => 'Doktor bu tarihte tatilde.'
            ]);
        }



        // Randevuları ve durumlarını saklıyoruz
        $appointments_data = [];
        foreach ($appointments as $appointment) {
            $appointments_data[] = [
                'time' => Carbon::parse($appointment->appointment_date_start)->format('H:i'),
                'status' => (bool) $appointment->appointment_status // boolean olarak alıyoruz
            ];
        }

        // Eğer çalışma programı varsa, zaman dilimlerini oluşturuyoruz
        if ($schedules->isNotEmpty()) {
            $times = $this->getTime( $appointments_data, $workDay); // Randevuları ve zaman dilimlerini geçiriyoruz

            // Eğer tüm zaman dilimleri dolmuşsa
            $allTimesFilled = !in_array(false, array_column($times, 'status'));

            if ($allTimesFilled) {
                $this->logUserAction(Auth::user(),"".$date." Bugün için tüm randevular dolu.", "danger");
                return response()->json([

                    'message' => 'Bugün için tüm randevular dolu.'
                ]);
            }


            return response()->json([
                'times' => $times
            ]);
        }

        $this->logUserAction(Auth::user(),"Uygun bir randevu, ".$date."bu zaman için bulunamadı.", "danger");
        return response()->json([
            'message' => 'Uygun bir randevu aradığınız zaman için bulunamadı.'
        ], 404);
    }

    public function getTime($appointments_data, $workDay)
    {
        $times = []; // Zaman dilimlerini saklayacağımız dizi

        // Spesifik olarak engelleyebileceğimiz zamanlar
        $blocked_times = [
            '08:00', '08:30', '12:00', '12:30', '17:00'
        ];

        // Her bir zamanı duruma göre düzenleme
        $appointments = [];
        foreach ($appointments_data as $appointment) {
            $appointments[$appointment['time']] = $appointment['status'];
        }

        $work_time_start = Carbon::parse($workDay . ' 08:00'); // Çalışma başlangıç saati
        $work_time_end = Carbon::parse($workDay . ' 17:00'); // Çalışma bitiş saati

        // Bu loop yalnızca belirtilen günde olan zaman dilimlerini döngüye alacak
        while ($work_time_start <= $work_time_end) {
            $current_time = $work_time_start->format('H:i'); // Mevcut zaman dilimini formatla

            // Engellenmiş zaman dilimlerini atla
            if (in_array($current_time, $blocked_times)) {
                $work_time_start->addMinutes(30);
                continue;
            }

            // Randevunun durumu (status)
            $status = $appointments[$current_time] ?? false;

            // Zaman dilimi ve durumu listeye ekle
            $times[] = [
                'time' => $current_time,
                'status' => $status // Mevcut zaman diliminin durumu
            ];

            // 30 dakika arayla ilerle
            $work_time_start->addMinutes(30);
        }

        return $times;
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
