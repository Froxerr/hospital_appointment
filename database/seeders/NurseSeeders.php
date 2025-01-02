<?php

namespace Database\Seeders;

use App\Models\Nurse;
use App\Models\PatientPriority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class NurseSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("nurse");

        foreach ($jsonData as $data)
        {
            Nurse::create([
                'nurses_name' => $data->nurses_name,
                'nurses_surname' => $data->nurses_surname,
                'nurses_phone' => $data->nurses_phone,
                'nurses_email' => $data->nurses_email,
                'nurses_position' => $data->nurses_position,
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
