<?php

namespace Database\Seeders;

use App\Models\LogRecords;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class LogRecordSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("log_record");

        foreach ($jsonData as $data)
        {
            LogRecords::create([
                'user_id' => $data->user_id,
                'log_date' => $data->log_date,
                'log_description' => $data->log_description,
                'user_name' => $data->user_name,
                'user_email' => $data->user_email,
                'ip_address' => $data->ip_address,
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
