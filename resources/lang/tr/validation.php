<?php

return [
    'accepted' => ':Attribute kabul edilmelidir.',
    'accepted_if' => ':Attribute, :other değeri :value ise kabul edilmelidir.',
    'active_url' => ':Attribute geçerli bir URL olmalıdır.',
    'after' => ':Attribute mutlaka :date tarihinden sonra olmalıdır.',
    'after_or_equal' => ':Attribute mutlaka :date tarihinden sonra veya aynı tarihte olmalıdır.',
    'alpha' => ':Attribute sadece harflerden oluşmalıdır.',
    'alpha_dash' => ':Attribute sadece harflerden, rakamlardan ve tirelerden oluşmalıdır.',
    'alpha_num' => ':Attribute sadece harflerden ve rakamlardan oluşmalıdır.',
    'array' => ':Attribute mutlaka bir dizi olmalıdır.',
    'ascii' => ':Attribute yalnızca tek baytlık alfasayısal karakterler ve semboller içermelidir.',
    'attached' => 'Bu :attribute zaten tanımlı.',
    'before' => ':Attribute mutlaka :date tarihinden önce olmalıdır.',
    'before_or_equal' => ':Attribute mutlaka :date tarihinden önce veya aynı tarihte olmalıdır.',
    'between' => [
        'array' => ':Attribute mutlaka :min - :max arasında öge içermelidir.',
        'file' => ':Attribute mutlaka :min - :max kilobayt arasında olmalıdır.',
        'numeric' => ':Attribute mutlaka :min - :max arasında olmalıdır.',
        'string' => ':Attribute mutlaka :min - :max karakter arasında olmalıdır.',
    ],
    'boolean' => ':Attribute sadece doğru veya yanlış olmalıdır.',
    'confirmed' => ':Attribute tekrarı eşleşmiyor.',
    'current_password' => 'Parola hatalı.',
    'date' => ':Attribute geçerli bir tarih değil.',
    'date_equals' => ':Attribute mutlaka :date ile aynı tarihte olmalıdır.',
    'date_format' => ':Attribute mutlaka :format biçiminde olmalıdır.',
    'decimal' => ':Attribute, :decimal ondalık basamaklara sahip olmalıdır.',
    'declined' => ':Attribute kabul edilmemektedir.',
    'declined_if' => ':Attribute, :other değeri :value iken kabul edilmemektedir.',
    'different' => ':Attribute ile :other mutlaka birbirinden farklı olmalıdır.',
    'digits' => ':Attribute mutlaka :digits basamaklı olmalıdır.',
    'digits_between' => ':Attribute mutlaka en az :min, en fazla :max basamaklı olmalıdır.',
    'dimensions' => ':Attribute geçersiz resim boyutlarına sahip.',
    'distinct' => ':Attribute alanı yinelenen bir değere sahip.',
    'email' => ':Attribute mutlaka geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':Attribute sadece şu değerlerden biriyle bitebilir: :values.',
    'enum' => 'Seçilen :attribute değeri geçersiz.',
    'exists' => 'Seçili :attribute geçersiz.',
    'file' => ':Attribute mutlaka bir dosya olmalıdır.',
    'filled' => ':Attribute mutlaka doldurulmalıdır.',
    'gt' => [
        'array' => ':Attribute mutlaka :value sayısından daha fazla öge içermelidir.',
        'file' => ':Attribute mutlaka :value kilobayt\'tan büyük olmalıdır.',
        'numeric' => ':Attribute mutlaka :value sayısından büyük olmalıdır.',
        'string' => ':Attribute mutlaka :value karakterden uzun olmalıdır.',
    ],
    'gte' => [
        'array' => ':Attribute mutlaka :value veya daha fazla öge içermelidir.',
        'file' => ':Attribute mutlaka :value kilobayt\'tan büyük veya eşit olmalıdır.',
        'numeric' => ':Attribute mutlaka :value sayısından büyük veya eşit olmalıdır.',
        'string' => ':Attribute mutlaka :value karakterden uzun veya eşit olmalıdır.',
    ],
    'image' => ':Attribute mutlaka bir resim olmalıdır.',
    'in' => 'Seçili :attribute geçersiz.',
    'in_array' => ':Attribute :other içinde mevcut değil.',
    'integer' => ':Attribute mutlaka bir tam sayı olmalıdır.',
    'ip' => ':Attribute mutlaka geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':Attribute mutlaka geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':Attribute mutlaka geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':Attribute mutlaka geçerli bir JSON içeriği olmalıdır.',
    'lt' => [
        'array' => ':Attribute mutlaka :value sayısından daha az öge içermelidir.',
        'file' => ':Attribute mutlaka :value kilobayt\'tan küçük olmalıdır.',
        'numeric' => ':Attribute mutlaka :value sayısından küçük olmalıdır.',
        'string' => ':Attribute mutlaka :value karakterden kısa olmalıdır.',
    ],
    'lte' => [
        'array' => ':Attribute mutlaka :value veya daha az öge içermelidir.',
        'file' => ':Attribute mutlaka :value kilobayt\'tan küçük veya eşit olmalıdır.',
        'numeric' => ':Attribute mutlaka :value sayısından küçük veya eşit olmalıdır.',
        'string' => ':Attribute mutlaka :value karakterden kısa veya eşit olmalıdır.',
    ],
    'mac_address' => ':Attribute geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => ':Attribute en fazla :max öge içerebilir.',
        'file' => ':Attribute en fazla :max kilobayt olabilir.',
        'numeric' => ':Attribute en fazla :max olabilir.',
        'string' => ':Attribute en fazla :max karakter olabilir.',
    ],
    'mimes' => ':Attribute mutlaka :values biçiminde bir dosya olmalıdır.',
    'mimetypes' => ':Attribute mutlaka :values biçiminde bir dosya olmalıdır.',
    'min' => [
        'array' => ':Attribute en az :min öge içerebilir.',
        'file' => ':Attribute en az :min kilobayt olabilir.',
        'numeric' => ':Attribute en az :min olabilir.',
        'string' => ':Attribute en az :min karakter olmalıdır.',
    ],
    'multiple_of' => ':Attribute, :value\'nin katları olmalıdır',
    'not_in' => 'Seçili :attribute geçersiz.',
    'not_regex' => ':Attribute biçimi geçersiz.',
    'numeric' => ':Attribute mutlaka bir sayı olmalıdır.',
    'password' => 'Parola geçersiz.',
    'present' => ':Attribute mutlaka mevcut olmalıdır.',
    'prohibited' => ':Attribute alanı kısıtlanmıştır.',
    'prohibited_if' => ':Other alanının değeri :value ise :attribute alanına veri girişi yapılamaz.',
    'prohibited_unless' => ':Other alanı :value değerlerinden birisi değilse :attribute alanına veri girişi yapılamaz.',
    'prohibits' => ':Attribute alanı :other alanının mevcut olmasını yasaklar.',
    'regex' => ':Attribute biçimi geçersiz.',
    'required' => ':Attribute mutlaka gereklidir.',
    'required_array_keys' => ':Attribute değeri şu verileri içermelidir: :values.',
    'required_if' => ':Attribute :other :value değerine sahip olduğunda mutlaka gereklidir.',
    'required_unless' => ':Attribute :other :values değerlerinden birine sahip olmadığında mutlaka gereklidir.',
    'required_with' => ':Attribute :values varken mutlaka gereklidir.',
    'required_with_all' => ':Attribute herhangi bir :values değeri varken mutlaka gereklidir.',
    'required_without' => ':Attribute :values yokken mutlaka gereklidir.',
    'required_without_all' => ':Attribute :values değerlerinden herhangi biri yokken mutlaka gereklidir.',
    'same' => ':Attribute ile :other aynı olmalıdır.',
    'size' => [
        'array' => ':Attribute mutlaka :size ögeye sahip olmalıdır.',
        'file' => ':Attribute mutlaka :size kilobayt olmalıdır.',
        'numeric' => ':Attribute mutlaka :size olmalıdır.',
        'string' => ':Attribute mutlaka :size karakterli olmalıdır.',
    ],
    'starts_with' => ':Attribute sadece şu değerlerden biriyle başlayabilir: :values.',
    'string' => ':Attribute mutlaka bir metin olmalıdır.',
    'timezone' => ':Attribute mutlaka geçerli bir saat dilimi olmalıdır.',
    'unique' => ':Attribute zaten alınmış.',
    'uploaded' => ':Attribute yüklemesi başarısız.',
    'url' => ':Attribute biçimi geçersiz.',
    'uuid' => ':Attribute mutlaka geçerli bir UUID olmalıdır.',
    'attributes' => [
        'password' => 'Şifre',
        'email' => 'E-posta',
        'name' => 'Ad',
        'username' => 'Kullanıcı adı',
        'first_name' => 'İsim',
        'last_name' => 'Soyisim',
        'phone' => 'Telefon',
        'mobile' => 'Cep telefonu',
        'address' => 'Adres',
        'city' => 'Şehir',
        'district' => 'İlçe',
        'country' => 'Ülke',
        'state' => 'Eyalet',
        'province' => 'İl',
        'company' => 'Şirket',
        'age' => 'Yaş',
        'gender' => 'Cinsiyet',
        'birthday' => 'Doğum tarihi',
        'date' => 'Tarih',
        'day' => 'Gün',
        'month' => 'Ay',
        'year' => 'Yıl',
        'hour' => 'Saat',
        'minute' => 'Dakika',
        'second' => 'Saniye',
        'title' => 'Başlık',
        'content' => 'İçerik',
        'description' => 'Açıklama',
        'summary' => 'Özet',
        'message' => 'Mesaj',
        'photo' => 'Fotoğraf',
        'image' => 'Görsel',
        'avatar' => 'Profil fotoğrafı',
        'file' => 'Dosya',
        'document' => 'Doküman',
        'terms' => 'Kullanım koşulları',
        'price' => 'Fiyat',
        'amount' => 'Tutar',
        'quantity' => 'Miktar',
        'code' => 'Kod',
        'captcha' => 'Güvenlik kodu',
        'website' => 'Web sitesi',
        'url' => 'Bağlantı',
        'slug' => 'Kısa ad',
        'category' => 'Kategori',
        'tag' => 'Etiket',
        'comment' => 'Yorum',
        'parent' => 'Üst',
        'status' => 'Durum',
        'role' => 'Rol',
        'permission' => 'İzin',
        'token' => 'Jeton',
        // diğer alanlar...
    ],
]; 