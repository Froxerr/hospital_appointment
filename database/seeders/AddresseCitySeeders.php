<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AddresseCitySeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("addresses_city"); //json formatından çöz ve jsonData adlı değişkene verileri at
        //jsonData içerisinde {{"ad":"İbrahim","soyad":"Aral"}, {"ad":"Nurşen", "soyad":"Aktaş"} } tarzında veri tutuyor
        //bu tutulan değer bir dizi olduğu için teker teker foreach ile döndürüyoruz
        foreach ($jsonData as $data)
        {
            City::create([ //benim city'de sadece şehir ismi ve sehir_id varmış
                //sehir_id otomatik arttığı için buraya yazmadım ama yazadabilirim.
                //buraya yazacağım tüm verilerin hepsi json'dan geliyor bu yüzden json'a gireceğin ilk değer
                //yukarıdaki örnekten ad,soyad değerleri veritabanınla aynı olması gerekiyor ki eklesin
                'city_name' => $data->city_name //burada da ekleme işlemi yapıyor
            ]);
        }
    }
    //: array php de methotun döneceği türü söylüyor biz java da hani
    // public void deneme()
    // public int deneme()
    // işte buradaki void ve int döndürme tipini phpde de : array olarak veriyoruz
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
