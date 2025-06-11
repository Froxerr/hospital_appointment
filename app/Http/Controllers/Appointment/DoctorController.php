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
        try {
            $addressId = $request->input('address_id');
            $specialtyId = $request->input('specialties_id');

            if (!$addressId || !$specialtyId) {
                return response()->json([
                    'message' => 'Gerekli bilgiler eksik.'
                ], 400);
            }

            $doctor = Doctor::where('address_id', $addressId)
                ->where('specialties_id', $specialtyId)
                ->get();

            if ($doctor->isNotEmpty()) {
                return response()->json([
                    'doctors' => $doctor
                ]);
            }

            return response()->json([
                'message' => 'Bu hastane için doktor bulunamadı.'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Bir hata oluştu, lütfen tekrar deneyin.'
            ], 500);
        }
    }

    private function logUserAction($user, $description, $badge = 'info')
    {
        try {
            if ($user) {
                LogRecords::create([
                    'user_id' => $user->id,
                    'log_description' => $description,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'badge' => $badge,
                    'ip_address' => request()->ip(),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Log kaydı oluşturulurken hata: ' . $e->getMessage());
        }
    }
}
