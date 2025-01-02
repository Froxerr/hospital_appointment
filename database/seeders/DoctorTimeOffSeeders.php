<?php

namespace Database\Seeders;

use App\Models\DoctorTimeOff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DoctorTimeOffSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("doctor_time_off");

        foreach ($jsonData as $data)
        {
            DoctorTimeOff::create([
                'doctor_id' => $data->doctor_id,
                'time_off_status' => $data->time_off_status,
                'time_off_date_start' => $data->time_off_date_start,
                'time_off_date_end' => $data->time_off_date_end
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
