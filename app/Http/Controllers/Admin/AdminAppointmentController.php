<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalAppointment;
use App\Models\Role;
use App\Models\LogRecords;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->paginate(10);

        $appointmentData = collect();

        foreach ($appointments as $appointment) {
            $status = $appointment->appointment_status ? 'Onaylandı' : 'İptal';
            $appointment_date_start = Carbon::parse($appointment->appointment_date_start);
            $doctor_full_name = 'Dr. ' . $appointment->doctor->doctor_name . ' ' . $appointment->doctor->doctor_surname;
            $patient_full_name = $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname;

            $appointmentData->push((object) [
                'id' => $appointment->hospital_appointment_id,
                'patient_name' => $patient_full_name,
                'doctor_name' => $doctor_full_name,
                'appointment_date' => $appointment_date_start->format('Y-m-d H:i'),
                'status' => $status,
            ]);
        }

        return [
            'appointmentData' => $appointmentData,
            'appointments' => $appointments,
        ];
    }

    public function show($id)
    {
        if (!Auth::check() || Auth::user()->role_id != 4) {
            return redirect('/');
        }

        $appointment = HospitalAppointment::with(['patient', 'doctor', 'hospitalAddress', 'floor', 'specialty'])
            ->where('hospital_appointment_id', $id)
            ->first();

        if (!$appointment) {
            return response()->json(['error' => 'Randevu bulunamadı'], 404);
        }

        $appointmentData = [
            'id' => $appointment->hospital_appointment_id,
            'patient' => [
                'name' => $appointment->patient->patients_name . ' ' . $appointment->patient->patients_surname,
                'email' => $appointment->patient->patients_email,
                'phone' => $appointment->patient->patients_phone
            ],
            'doctor' => [
                'name' => 'Dr. ' . $appointment->doctor->doctor_name . ' ' . $appointment->doctor->doctor_surname,
                'specialty' => $appointment->specialty->specialty_name
            ],
            'appointment' => [
                'date' => Carbon::parse($appointment->appointment_date_start)->format('Y-m-d'),
                'time' => Carbon::parse($appointment->appointment_date_start)->format('H:i'),
                'status' => $appointment->appointment_status ? 'Onaylandı' : 'İptal',
                'location' => $appointment->hospitalAddress->address_name . ' - ' . $appointment->floor->floor_name
            ]
        ];

        return response()->json($appointmentData);
    }

    public function update($id)
    {
        if (!Auth::check() || Auth::user()->role_id != 4) {
            return response()->json(['error' => 'Yetkilendirme hatası'], 403);
        }

        try {
            $appointment = HospitalAppointment::find($id);

            if (!$appointment) {
                \Log::error("Randevu güncelleme hatası: ID {$id} bulunamadı");
                return response()->json(['error' => 'Randevu bulunamadı'], 404);
            }

            // Randevu durumunu tersine çevir
            $appointment->appointment_status = !$appointment->appointment_status;
            
            if (!$appointment->save()) {
                \Log::error("Randevu kaydetme hatası: ID {$id}");
                return response()->json(['error' => 'Randevu kaydedilemedi'], 500);
            }

            // Log kaydı oluştur
            $this->createLog(
                Auth::user()->id,
                'Randevu durumu güncellendi: ' . ($appointment->appointment_status ? 'Onaylandı' : 'İptal edildi'),
                'warning'
            );

            return response()->json([
                'success' => true,
                'message' => 'Randevu durumu başarıyla güncellendi',
                'status' => $appointment->appointment_status ? 'Onaylandı' : 'İptal'
            ]);

        } catch (\Exception $e) {
            \Log::error("Randevu güncelleme hatası: " . $e->getMessage());
            return response()->json(['error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role_id != 4) {
            return response()->json(['error' => 'Yetkilendirme hatası'], 403);
        }

        try {
            DB::beginTransaction();

            $appointment = HospitalAppointment::find($id);

            if (!$appointment) {
                \Log::error("Randevu silme hatası: ID {$id} bulunamadı");
                return response()->json(['error' => 'Randevu bulunamadı'], 404);
            }

            // İlişkili kayıtları sil
            DB::table('patient_appointment_histories')
                ->where('appointment_history_id', $id)
                ->delete();

            // Randevuyu sil
            if (!$appointment->delete()) {
                DB::rollBack();
                \Log::error("Randevu silme hatası: ID {$id} silinemedi");
                return response()->json(['error' => 'Randevu silinemedi'], 500);
            }

            DB::commit();

            // Log kaydı oluştur
            $this->createLog(
                Auth::user()->id,
                'Randevu silindi: #' . $id,
                'danger'
            );

            return response()->json([
                'success' => true,
                'message' => 'Randevu başarıyla silindi'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Randevu silme hatası: " . $e->getMessage());
            return response()->json(['error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    private function createLog($userId, $description, $badge)
    {
        $user = Auth::user();
        LogRecords::create([
            'user_id' => $userId,
            'log_description' => $description,
            'user_name' => $user->name . ' ' . $user->surname,
            'user_email' => $user->email,
            'badge' => $badge,
            'ip_address' => request()->ip()
        ]);
    }
}
