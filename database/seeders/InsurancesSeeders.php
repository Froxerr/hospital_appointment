<?php

namespace Database\Seeders;

use App\Models\Insurance;
use App\Models\InsuranceTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class InsurancesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("insurance");

        foreach ($jsonData as $data)
        {
            Insurance::create([
                'insurance_type_id' => $data->insurance_type_id,
                'insurance_date_start' => $data->insurance_date_start,
                'insurance_date_end' => $data->insurance_date_end,
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
