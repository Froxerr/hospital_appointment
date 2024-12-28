<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\LogRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function getDistrictsByCity(Request $request)
    {
        $cityId = $request->input('city_id');

        // Sadece city_id'ye göre ilçeleri alıyoruz
        $districts = District::where('city_id', $cityId)->get();

        // İlçeler bulunduysa döndür
        if ($districts->isNotEmpty()) {
            return response()->json([
                'districts' => $districts
            ]);
        }

        $this->logUserAction(Auth::user(),"".$cityId."idli şehir de ilçe bulunamadı.", "danger");
        return response()->json([
            'message' => 'Aradığınız şehir de ilçe bulunamadı.'
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
