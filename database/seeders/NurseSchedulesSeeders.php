<?php

namespace Database\Seeders;

use App\Models\NurseSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class NurseSchedulesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("nurse_schedules");

        foreach ($jsonData as $data)
        {
            NurseSchedule::create([
                'nurse_id' => $data->nurse_id,
                'work_day' => $data->work_day,
                'work_time_start' => $data->work_time_start,
                'work_time_end' => $data->work_time_end
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
