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
                    <div class="col-md-12">
                        <form action="/appointment-update/{{ $appointmentData->hospital_appointment_id }}" method="post" role="form" class="php-email-form">
                            @csrf
                            @method('PUT')
                            <!-- Ana Kategori ve Alt Bölüm Seçimi -->
                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="category">Bölüm Seçin</label>
                                    <select name="category" id="category" class="form-select" required>
                                        <option value="">Bölüm Seçin</option>
                                        <option value="Hastane Randevu" data-name="Hastane Randevu" selected>Hastane Randevu</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label for="sub-category">Poliklinik Seçin</label>
                                    <select name="sub_category" id="sub-category" class="form-select" required>
                                        <option value="">Poliklinik Seçin</option>
                                        @foreach($specialties as $specialti)
                                            <option value="{{$specialti->specialty_id}}" data-name="{{$specialti->specialty_name}}" @if($appointmentData && $appointmentData->specialties_id == $specialti->specialty_id) selected @endif>{{$specialti->specialty_name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Şehir ve İlçe Seçimi -->
                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="city">Şehir Seçin</label>
                                    <select name="city" id="city" class="form-select" required>
                                        <option value="">Şehir Seçin</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->city_id}}" data-name="{{$city->city_name}}" @if($city_id == $city->city_id) selected @endif>{{$city->city_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label for="district">İlçe Seçin</label>
                                    <select name="district" id="district" class="form-select" required>
                                        <option value="">İlçe Seçin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Doktor Seçimi ve Randevu Zamanı -->
                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="hospital">Hastane Seçin</label>
                                    <select name="hospital" id="hospital" class="form-select" required>
                                        <option value="">Hastane Seçin</option>
                                    </select>
                                </div>
                                <input type="hidden" name="floor_id" id="floor_id">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="doctor">Doktor Seçin</label>
                                    <select name="doctor" id="doctor" class="form-select" required>
                                        <option value="">Doktor Seçin</option>
                                    </select>
                                </div>

                            </div>
                            <!-- Randev Saat -->
                            <div class="row">
                                <div class="col-md-6 form-group mt-3">
                                    <label for="date">Tarihi Seçin</label>
                                    <input type="date" name="date" id="date" class="form-select" required min="{{ \Carbon\Carbon::now()->addHours(3)->toDateString() }}">
                                </div>
                                <div class="col-md-6 form-group mt-3">
                                    <label for="time">Saat Seçin</label>
                                    <select name="time" id="time" class="form-select" required>
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
                            <div class="mt-3">
                                <div class="text-center"><button type="submit">Randevu Güncelle</button></div>
                            </div>
                            <!-- Gizli input -->
                            <input type="hidden" id="selected_hospital_name" value="{{$address_name}}">
                            <input type="hidden" id="selected_district_id" value="{{$district_id}}">
                            <input type="hidden" id="selected_doctor_id" value="{{$appointmentData->doctor_id}}">
                            <input type="hidden" id="selected_date" value="{{$appointmentDate}}">
                            <input type="hidden" id="selected_time" value="{{$appointmentTime}}">


                        </form>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection

@section('js')
    <script src="{{asset("assets/js/toastr.js")}}"></script>
    <script src="{{asset("assets/js/appointment-update.js")}}"></script>
@endsection

