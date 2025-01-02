<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("user");

        foreach ($jsonData as $data)
        {
            User::create([
                'id' => $data->id,
                'name' => $data->name,
                'surname' => $data->surname,
                'email' => $data->email,
                'email_verified_at' => $data->email_verified_at,
                'phone' => $data->phone,
                'password' => $data->password,
                'role_id' => $data->role_id,
                'registration_date' => $data->registration_date,
                'updated_date' => $data->updated_date,
                'remember_token' => $data->remember_token,
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
