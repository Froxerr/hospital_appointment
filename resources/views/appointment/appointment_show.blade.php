@extends("front.layout")

@section("icerik")
    <main class="main">
        <section id="appointment-show" class="appointment section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Randevularım</h2>
            </div><!-- End Section Title -->

            <!-- Filtreleme Alanı -->
            <div class="container mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h5 class="card-title mb-3">Randevuları Filtrele</h5>
                    <form action="{{ route('appointment.show') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label small text-muted">Başlangıç Tarihi</label>
                                <input type="date" class="form-control rounded-lg shadow-sm" id="start_date" name="start_date" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label small text-muted">Bitiş Tarihi</label>
                                <input type="date" class="form-control rounded-lg shadow-sm" id="end_date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label small text-muted">Durum</label>
                                <select class="form-select rounded-lg shadow-sm" id="status" name="status">
                                    <option value="">Tümü</option>
                                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="İptal" {{ request('status') == 'İptal' ? 'selected' : '' }}>İptal</option>
                                    <option value="Tamamlandı" {{ request('status') == 'Tamamlandı' ? 'selected' : '' }}>Tamamlandı</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="policlinic" class="form-label small text-muted">Poliklinik</label>
                                <select class="form-select rounded-lg shadow-sm" id="policlinic" name="policlinic">
                                    <option value="">Tümü</option>
                                    @foreach($specialties as $specialty)
                                        <option value="{{ $specialty->specialty_id }}" {{ request('policlinic') == $specialty->specialty_id ? 'selected' : '' }}>{{ $specialty->specialty_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100 btn-lg rounded-lg shadow-sm">Filtrele</button>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="{{ route('appointment.show') }}" class="btn btn-secondary w-100 btn-lg rounded-lg shadow-sm">Filtreyi Temizle</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('message'))
                <div class="container">
                    <div class="alert alert-info text-center" role="alert">
                        {{ session('message') }}
                    </div>
                </div>
            @elseif($appointmentsGetData->isEmpty())
                <div class="container">
                    <div class="alert alert-warning text-center" role="alert">
                        @if(request()->hasAny(['policlinic', 'start_date', 'end_date', 'status']))
                            Seçilen kriterlere uygun randevu bulunamadı.
                        @else
                            Henüz bir randevunuz bulunmamaktadır.
                        @endif
                    </div>
                </div>
            @else
                <div class="container" data-aos="fade-up" data-aos-delay="100">
                    <div class="row">
                    @foreach($appointmentsGetData as $index => $appointment)
                        @if($index % 2 == 0 && $index != 0)
                            </div><div class="row">
                        @endif
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-lg border-0 rounded-4">
                                <div class="card-header bg-primary text-white fs-5 fw-bold rounded-top-4">
                                    Randevu: {{ $appointment['policlinic_name'] }}
                                </div>
                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <!-- Sol Taraf: Tarih ve Saat -->
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-calendar-event fs-4 text-primary me-2"></i>
                                                <div>
                                                    <small class="text-muted">Tarih:</small>
                                                    <div class="fw-bold fs-6">{{ $appointment['appointment_date'] }}</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-clock fs-4 text-primary me-2"></i>
                                                <div>
                                                    <small class="text-muted">Saat:</small>
                                                    <div class="fw-bold fs-6">{{ $appointment['appointment_time'] }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sağ Taraf: Butonlar -->
                                       @if(!($appointment["status"] == "İptal"))
                                        <div class="d-flex flex-column gap-2">
                                            <form method="POST" action="/appointment-show">
                                                @csrf
                                                <input type="hidden" name="appointment_id" value="{{ $appointment['id'] }}">
                                                <button type="submit" class="btn btn-danger btn-lg w-100">İptal Et</button>
                                            </form>
                                            <a href="/appointment-update?id={{ $appointment['id'] }}">
                                                <button type="button" class="btn btn-primary btn-lg w-100">Güncelle</button>
                                            </a>
                                        </div>
                                        @endif
                                    </div>

                                    <hr class="my-3">

                                    <div class="randevu-detay d-flex flex-column gap-2 mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-hospital fs-5 text-secondary me-2"></i>
                                            <div><small class="text-muted">Hastane Adı:</small> <span class="fw-bold">{{ $appointment['hospital_name'] }}</span></div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt fs-5 text-secondary me-2"></i>
                                            <div><small class="text-muted">Hastane Adresi:</small> <span class="fw-bold">{{ $appointment['hospital_address'] }}</span></div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-building fs-5 text-secondary me-2"></i>
                                            <div><small class="text-muted">Hastane Katı:</small> <span class="fw-bold">{{ $appointment['floor_name'] }}</span></div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-badge fs-5 text-secondary me-2"></i>
                                            <div><small class="text-muted">Doktor Adı:</small> <span class="fw-bold">{{ $appointment['doctor_name'] }}</span></div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-auto">
                                        <span class="badge {{ $appointment['status'] == 'İptal' ? 'bg-danger' : 'bg-success' }} fs-6 p-2 rounded-pill">
                                            Randevu Durumu: {{ $appointment['status'] }}
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
