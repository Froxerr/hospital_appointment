@extends("front.layout")

@section("icerik")
    <main class="main">
        <section id="appointment" class="appointment section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Randevu Güncelleme</h2>
                <p>Randevu bilgilerinizi güncelleyebilirsiniz. Lütfen tüm alanları eksiksiz doldurunuz.</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <form action="/appointment-update/{{ $appointmentData->hospital_appointment_id }}" method="post" role="form" class="php-email-form">
                            @csrf
                            @method('PUT')

                            <!-- Uyarı Mesajları -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Ana Kategori ve Alt Bölüm Seçimi -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="category" class="form-label">Bölüm</label>
                                    <select name="category" id="category" class="form-select" required tabindex="1">
                                        <option value="">Bölüm Seçin</option>
                                        <option value="Hastane Randevu" data-name="Hastane Randevu" selected>Hastane Randevu</option>
                                    </select>
                                    <div class="invalid-feedback">Lütfen bölüm seçin</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="sub-category" class="form-label">Poliklinik</label>
                                    <select name="sub_category" id="sub-category" class="form-select" required tabindex="2">
                                        <option value="">Poliklinik Seçin</option>
                                        @foreach($specialties as $specialti)
                                            <option value="{{$specialti->specialty_id}}" data-name="{{$specialti->specialty_name}}"
                                                @if($appointmentData && $appointmentData->specialties_id == $specialti->specialty_id) selected @endif>
                                                {{$specialti->specialty_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Lütfen poliklinik seçin</div>
                                </div>
                            </div>

                            <!-- Şehir ve İlçe Seçimi -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label">Şehir</label>
                                    <select name="city" id="city" class="form-select" required tabindex="3">
                                        <option value="">Şehir Seçin</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->city_id}}" data-name="{{$city->city_name}}"
                                                @if($city_id == $city->city_id) selected @endif>
                                                {{$city->city_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Lütfen şehir seçin</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="district" class="form-label">İlçe</label>
                                    <select name="district" id="district" class="form-select" required tabindex="4">
                                        <option value="">İlçe Seçin</option>
                                    </select>
                                    <div class="invalid-feedback">Lütfen ilçe seçin</div>
                                </div>
                            </div>

                            <!-- Hastane ve Doktor Seçimi -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label for="hospital" class="form-label">Hastane</label>
                                    <select name="hospital" id="hospital" class="form-select" required tabindex="5">
                                        <option value="">Hastane Seçin</option>
                                    </select>
                                    <div class="invalid-feedback">Lütfen hastane seçin</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="doctor" class="form-label">Doktor</label>
                                    <select name="doctor" id="doctor" class="form-select" required tabindex="6">
                                        <option value="">Doktor Seçin</option>
                                    </select>
                                    <div class="invalid-feedback">Lütfen doktor seçin</div>
                                </div>
                            </div>

                            <!-- Tarih ve Saat Seçimi -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Tarih</label>
                                    <input type="date" name="date" id="date" class="form-control" required tabindex="7"
                                           min="{{ \Carbon\Carbon::now()->addHours(3)->toDateString() }}">
                                    <div class="invalid-feedback">Lütfen tarih seçin</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="time" class="form-label">Saat</label>
                                    <select name="time" id="time" class="form-select" required tabindex="8">
                                        <option value="">Saat Seçin</option>
                                    </select>
                                    <div class="invalid-feedback">Lütfen saat seçin</div>
                                </div>
                            </div>

                            <!-- Gizli Alanlar -->
                            <input type="hidden" name="floor_id" id="floor_id">
                            <input type="hidden" id="selected_hospital_name" value="{{$address_name}}">
                            <input type="hidden" id="selected_district_id" value="{{$district_id}}">
                            <input type="hidden" id="selected_doctor_id" value="{{$appointmentData->doctor_id}}">
                            <input type="hidden" id="selected_date" value="{{$appointmentDate}}">
                            <input type="hidden" id="selected_time" value="{{$appointmentTime}}">

                            <!-- Form Butonları -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <a href="/appointment-show" class="btn btn-secondary w-100" tabindex="10">
                                        <i class="fas fa-arrow-left me-2"></i>Geri Dön
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-100" tabindex="9">
                                        <i class="fas fa-save me-2"></i>Randevu Güncelle
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-select, .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Dark mode styles */
        body.dark-mode .form-select,
        body.dark-mode .form-control {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #e5e7eb;
        }

        body.dark-mode .form-select:focus,
        body.dark-mode .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.25);
        }

        body.dark-mode .form-label {
            color: #e5e7eb;
        }

        body.dark-mode .alert {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #e5e7eb;
        }

        body.dark-mode .invalid-feedback {
            color: #ef4444;
        }
    </style>
@endsection

@section('js')
    <script src="{{asset("assets/js/toastr.js")}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset("assets/js/appointment-update.js")}}"></script>
@endsection

