<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\HospitalAppointmentFloor;
use App\Models\LogRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HospitalController extends Controller
{
    public function getHospitals(Request $request)
    {
        $districtId = $request->input('district_id'); // İlçe ID'sini alıyoruz

        // Address tablosundan, district_id'ye göre hastaneleri alıyoruz
        $hospitals = Address::where('address_district_id', $districtId)->get();

        // Hastaneler bulunduysa
        if ($hospitals->isNotEmpty()) {
            // Sonuçları tutacağımız bir dizi oluşturuyoruz
            $responseHospitals = [];
            $floors = HospitalAppointmentFloor::where('hospital_address_id', $districtId)->get();

            foreach ($hospitals as $hospital) {
                if ($floors->isNotEmpty()) {
                    // Rastgele bir kat seçiyoruz
                    $randomFloor = $floors->random(); // Değerler arasından rastgele birini alıyoruz

                    // Hastane bilgilerini ve rastgele seçilen katı ekliyoruz
                    $responseHospitals[] = [
                        'hospital' => $hospital,
                        'random_floor' => [
                            'id' => $randomFloor->hospital_appointment_floor_id,
                            'block_name' => $randomFloor->hospital_block_name ?? 'Blok bilgisi yok',
                            'room_number' => $randomFloor->hospital_room_number ?? 'Oda numarası yok',
                        ]
                    ];
                } else {
                    // Eğer hastanenin katı yoksa, sadece hastaneyi ekliyoruz
                    $responseHospitals[] = [
                        'hospital' => $hospital,
                        'random_floor' => [] // Katları boş bir dizi olarak gönderiyoruz
                    ];
                }
            }

            // Hastaneler ve katlar döndürüyoruz
            return response()->json([
                'hospitals' => $responseHospitals
            ]);
        }else{
        $this->logUserAction(Auth::user(),"Bu ilçede:".$districtId." hastane bulunamadı.", "danger");
        // Eğer hastane bulunmazsa
        return response()->json([
            'message' => 'Bu ilçede hastane bulunamadı.'
        ], 404);
        }
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
