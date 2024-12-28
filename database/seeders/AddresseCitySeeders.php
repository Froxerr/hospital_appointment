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
    public function getDecode(string $rote): array //tekrar tekrar aynı şeyi 50 defa kullanacağımız için bir fonksiyon oluşturdum
    {
        $prioritiesJson = Storage::get('seeders/'.$rote.'.json'); //Storage adlı bir class bu class bizim sol klasörlerden
        //storage adlı dosyanın alt klasörlerine bakıyor
        //seeders diye bir klasör oluşturdum onun içindeki gelen rote(adsasdas) adsasdas.json ekliyor ve değeri otomatik alıyor

        // JSON verisini çözümleyin, diziler olarak almak için ikinci parametreyi true yapın
        $decodedData = json_decode($prioritiesJson);
        //eğer 2. değeri true olarak verirsen değerler dizi halinde dönecek sana obje halinde değil
        //dizi ile obje arasındaki fark
        //dizi de ad["ibrahim"] | ad[2] tarzında bildiğin dizi de eriştiğin şekilde erişiyorsun
        //obje de ise -> ile ulaşıyorsun ad->ibrahim | ad->2 tarzında bir kullanıma sahip değil aslında objelerde indiks sistemi yok [0] muhabbeti
        //[0] dediğim de ["elma","armut","meyve"]
        // [0] dediğim de mesela elma gelecek işte o muhabbet


        // JSON hatasını kontrol et | json kontrol dosyası bu da eğer hata verirse kontrol etsin diye
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON çözümleme hatası: ' . json_last_error_msg());
        }

        return $decodedData; //en sonunda tüm verileri bize geri döndürüyor
    }
}
