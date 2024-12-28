<?php

namespace Database\Seeders;

use App\Models\VaccineAppointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class VaccineAppointmentSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("vaccine_appointment");

        foreach ($jsonData as $data)
        {
            VaccineAppointment::create([
                'vaccines_id' => $data->vaccines_id,
                'patients_id' => $data->patients_id,
                'nurse_id' => $data->nurse_id,
                'hospital_addresses_id' => $data->hospital_addresses_id,
                'vaccine_appointment_date' => $data->vaccine_appointment_date,
                'vaccine_appointment_status' => $data->vaccine_appointment_status
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
