<?php

namespace Database\Seeders;

use App\Models\HospitalAppointment;
use App\Models\Insurance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class HospitalAppointmentSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("hospital_appointment");

        foreach ($jsonData as $data)
        {
            HospitalAppointment::create([
                'patient_id' => $data->patient_id,
                'hospital_address_id' => $data->hospital_address_id,
                'hospital_appointment_floor_id' => $data->hospital_appointment_floor_id,
                'doctor_id' => $data->doctor_id,
                'specialties_id' => $data->specialties_id,
                'appointment_name' => $data->appointment_name,
                'appointment_date_start' => $data->appointment_date_start,
                'appointment_date_end' => $data->appointment_date_end,
                'appointment_status' => $data->appointment_status
            ]);
        }
    }

    public function getDecode(string $rote): array
    {
        $jsonPath = database_path('data/'.$rote.'.json');
        $prioritiesJson = file_get_contents($jsonPath);
        // JSON verisini çözümleyin, diziler olarak almak için ikinci parametreyi true yapın
        $decodedData = json_decode($prioritiesJson);

        // JSON hatasını kontrol et
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON çözümleme hatası: ' . json_last_error_msg());
        }

        return $decodedData;
    }
}
