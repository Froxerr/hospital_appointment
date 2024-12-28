@extends("front.layout")

@section("icerik")
    <main class="main">
        <section id="appointment-show" class="appointment section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Randevularım</h2>
            </div><!-- End Section Title -->

            @if(session('message'))
                <h5 class="text-center" data-aos="fade-up" data-aos-delay="100">{{ session('message') }}</h5>
            @else
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    @foreach($appointmentsGetData as $index => $appointment)
                        @if($index % 2 == 0 && $index != 0)
                </div><div class="row">  <!-- Yeni bir satır başlatılıyor, 2'den fazla randevu varsa -->
                    @endif
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Randevu: {{ $appointment['policlinic_name'] }}
                            </div>
                            <div class="card-body">
                                <div class="randevu-bilgisi d-flex justify-content-between align-items-center">
                                    <!-- Sol Taraf: Tarih ve Saat -->
                                    <div class="randevu-tarih-saat">
                                        <div class="randevu-tarihi">Tarih: {{ $appointment['appointment_date'] }}</div>
                                        <div class="randevu-saat">Saat: {{ $appointment['appointment_time'] }}</div>
                                    </div>

                                    <!-- Sağ Taraf: Butonlar -->
                                   @if(!($appointment["status"] == "İptal"))
                                    <div class="randevu-butonlar d-flex flex-column">
                                        <form method="POST" action="/appointment-show" class="mb-2">
                                            @csrf
                                            <input type="hidden" name="appointment_id" value="{{ $appointment['id'] }}">
                                            <button type="submit" class="btn btn-iptal">İptal Et</button>
                                        </form>
                                        <a href="/appointment-update?id={{ $appointment['id'] }}">
                                            <button type="button" class="btn btn-guncelle">Güncelle</button>
                                        </a>
                                    </div>
                                    @endif
                                </div>


                                <div class="randevu-detay">
                                    <div><span>Hastane Adı:</span> {{ $appointment['hospital_name'] }}</div>
                                    <div><span>Hastane Adresi:</span> {{ $appointment['hospital_address'] }}</div>
                                    <div><span>Hastane Katı:</span> {{ $appointment['floor_name'] }}</div>
                                    <div><span>Doktor Adı:</span> {{ $appointment['doctor_name'] }}</div>
                                </div>

                                <div class="randevu-durum" style="font-size: 1.1rem; color: {{ $appointment['status'] == 'İptal' ? '#dc3545' : '#28a745' }};">
                                    Randevu Durumu:
                                    <span>
                                        {{ $appointment['status'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

            @endif

        </section>
    </main>
@endsection
