@extends("front.layout")

@section("icerik")
    <main class="main">
        <section id="appointment" class="appointment section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Randevu</h2>
                <p>Randevu, müşterilerle doğru zamanda buluşarak ihtiyaçlarına çözüm sunmak için planlanmış bir fırsattır.</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    <div class="col-md-8">
                        <form action="/appointment" method="post" role="form" class="php-email-form bg-white rounded-xl shadow-lg p-6 space-y-6">
                        @csrf
                            <!-- Ana Kategori ve Alt Bölüm Seçimi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Bölüm Seçin</label>
                                    <select name="category" id="category" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required>
                                        <option value="">Bölüm Seçin</option>
                                        <option value="Hastane Randevu" data-name="Hastane Randevu">Hastane Randevu</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="sub-category" class="block text-sm font-medium text-gray-700 mb-1">Poliklinik Seçin</label>
                                    <select name="sub_category" id="sub-category" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required>
                                        <option value="">Poliklinik Seçin</option>
                                        @foreach($specialties as $specialti)
                                        <option value="{{$specialti->specialty_id}}" data-name="{{$specialti->specialty_name}}">{{$specialti->specialty_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Şehir ve İlçe Seçimi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Şehir Seçin</label>
                                    <select name="city" id="city" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required>
                                        <option value="">Şehir Seçin</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->city_id}}" data-name="{{$city->city_name}}">{{$city->city_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="district" class="block text-sm font-medium text-gray-700 mb-1">İlçe Seçin</label>
                                    <select name="district" id="district" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required>
                                        <option value="">İlçe Seçin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Doktor Seçimi ve Randevu Zamanı -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="hospital" class="block text-sm font-medium text-gray-700 mb-1">Hastane Seçin</label>
                                    <select name="hospital" id="hospital" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required>
                                        <option value="">Hastane Seçin</option>
                                    </select>
                                </div>
                                <input type="hidden" name="floor_id" id="floor_id">
                                <div>
                                    <label for="doctor" class="block text-sm font-medium text-gray-700 mb-1">Doktor Seçin</label>
                                    <select name="doctor" id="doctor" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required>
                                        <option value="">Doktor Seçin</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Randev Saat -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tarihi Seçin</label>
                                    <input type="date" name="date" id="date" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required min="{{ \Carbon\Carbon::now()->addHours(3)->toDateString() }}">
                                </div>
                                <div>
                                    <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Saat Seçin</label>
                                    <select name="time" id="time" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required>
                                        <option value="">Saat Seçin</option>
                                    </select>
                                </div>
                            </div>
                            @if(session('swal_message'))
                                <script>
                                    Swal.fire({
                                        icon: '{{ session('swal_type') }}',
                                        title: '{{ session('swal_message') }}',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                </script>
                            @endif
                            <div class="pt-2">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition duration-200">Randevu Oluştur</button>
                            </div>

                        </form>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="card shadow-sm border-0 rounded-4 p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                                    <i class="bi bi-person-circle fs-3"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Ad</div>
                                    <div class="fw-bold fs-6">{{Auth::getUser()->name}}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                                    <i class="bi bi-person-lines-fill fs-3"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Soyad</div>
                                    <div class="fw-bold fs-6">{{Auth::getUser()->surname}}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                                    <i class="bi bi-envelope fs-3"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">E-posta</div>
                                    <div class="fw-bold fs-6">{{Auth::getUser()->email}}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info bg-opacity-10 text-info rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                                    <i class="bi bi-telephone fs-3"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Telefon</div>
                                    <div class="fw-bold fs-6">{{Auth::getUser()->phone}}</div>
                                </div>
                            </div>
                            <div id="dynamic-info">
                                {{-- Dinamik olarak gelecek bilgiler buraya yerleşecek --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection

@section('js')
    <script src="{{asset("assets/js/toastr.js")}}"></script>
    <script src="{{asset("assets/js/appointment.js")}}"></script>
@endsection

