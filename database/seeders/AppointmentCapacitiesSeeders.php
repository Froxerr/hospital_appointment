<?php

namespace Database\Seeders;

use App\Models\AppointmentCapacity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AppointmentCapacitiesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("appointment_capacities");

        foreach ($jsonData as $data)
        {
            AppointmentCapacity::create([
                'appointment_hospital_id' => $data->appointment_hospital_id,
                'number_of_appointment' => $data->number_of_appointment,
                'max_capacity' => $data->max_capacity,
                'available_capacity' => $data->available_capacity
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
