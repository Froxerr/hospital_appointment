<?php

namespace Database\Seeders;

use App\Models\Patients;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PatientSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("patient");

        foreach ($jsonData as $data)
        {
            Patients::create([
                'patients_insurances_id' => $data->patients_insurances_id,
                'patients_name' => $data->patients_name,
                'patients_surname' => $data->patients_surname,
                'patients_phone' => $data->patients_phone,
                'patients_gender' => $data->patients_gender,
                'patients_email' => $data->patients_email
            ]);
        }
    }


    public function getDecode($rote): array
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
