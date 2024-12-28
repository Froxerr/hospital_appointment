<?php

namespace Database\Seeders;

use App\Models\HospitalAppointmentFloor;
use App\Models\Insurance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class HospitalAppointmentFloorSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("hospital_appointment_floor");

        foreach ($jsonData as $data)
        {
            HospitalAppointmentFloor::create([
                'hospital_address_id' => $data->hospital_address_id,
                'hospital_room_number' => $data->hospital_room_number,
                'hospital_block_name' => $data->hospital_block_name,
                'hospital_floor_number' => $data->hospital_floor_number
            ]);
        }
    }

    public function getDecode(string $rote): array
    {
        $prioritiesJson = Storage::get('seeders/'.$rote.'.json');
        // JSON verisini çözümleyin, diziler olarak almak için ikinci parametreyi true yapın
        $decodedData = json_decode($prioritiesJson);

        // JSON hatasını kontrol et
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON çözümleme hatası: ' . json_last_error_msg());
        }

        return $decodedData;
    }
}
