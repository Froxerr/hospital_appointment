<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\LogRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function getDoctor(Request $request)
    {
        $addressId = $request->input('address_id');
        $specialtyId = $request->input('specialties_id');

        // Address tablosundan, district_id'ye ve hastane türüne göre adresleri alıyoruz
        // Eğer Address tablosunda 'type' veya benzeri bir alan varsa, onu da kontrol edebiliriz
        $doctor = Doctor::where('address_id', $addressId)
            ->where('specialties_id', $specialtyId)
            ->get();

        // Hastaneler bulunduysa döndür
        if ($doctor->isNotEmpty()) {
            return response()->json([
                'doctors' => $doctor
            ]);
        }

        $this->logUserAction(Auth::user(),"Bu hastane için doktor bulunamadı, Adres id: ".$addressId. " ve İlçe id: ".$specialtyId, "danger");
        return response()->json([
            'message' => 'Bu hastane için doktor bulunamadı.'
        ], 404);
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
