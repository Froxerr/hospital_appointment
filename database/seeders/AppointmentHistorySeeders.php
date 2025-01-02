<?php

namespace Database\Seeders;

use App\Models\PatientAppointmentHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AppointmentHistorySeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("appointment_history");

        foreach ($jsonData as $data)
        {
            PatientAppointmentHistory::create([
                'patient_history_id' => $data->patient_history_id,
                'hospital_history_address_id' => $data->hospital_history_address_id,
                'hospital_history_appointment_floor_id' => $data->hospital_history_appointment_floor_id,
                'doctor_history_id' => $data->doctor_history_id,
                'specialties_history_id' => $data->specialties_history_id,
                'appointment_insurance_history_id' => $data->appointment_insurance_history_id,
                'appointment_history_id' => $data->appointment_history_id,
                'appointment_history_name' => $data->appointment_history_name,
                'appointment_history_date_start' => $data->appointment_history_date_start,
                'appointment_history_date_end' => $data->appointment_history_date_end,
                'appointment_history_status' => $data->appointment_history_status,
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
