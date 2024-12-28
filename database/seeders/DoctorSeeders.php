<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Subspecialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DoctorSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("doctor");

        foreach ($jsonData as $data)
        {
            Doctor::create([
                'specialties_id' => $data->specialties_id,
                'address_id' => $data->address_id,
                'doctor_name' => $data->doctor_name,
                'doctor_surname' => $data->doctor_surname,
                'doctor_phone' => $data->doctor_phone,
                'doctor_email' => $data->doctor_email,
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
