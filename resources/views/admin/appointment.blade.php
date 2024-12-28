@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Navbar veya Sidebar buraya eklenebilir -->
        <div class="row mt-4">
            <div class="col-12">
                <h3 class="text-center hospital-dashboard-title">Randevu Geçmişi</h3>

                <!-- Arama ve Filtreleme Alanı -->
                <div class="d-flex justify-content-between mb-3">
                    <!-- Arama -->
                    <input type="text" class="form-control w-50" id="logSearch" placeholder="Loglarda ara...">
                    <!-- Filtreleme -->
                    <select class="form-select w-25" id="logFilter">
                        <option value="">Filtrele (Tümünü Göster)</option>
                        <option value="info">Bilgi</option>
                        <option value="error">Hata</option>
                        <option value="warning">Uyarı</option>
                    </select>
                </div>

                <table id="appointmentsTable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Hasta Adı</th>
                        <th>Doktor</th>
                        <th>Randevu Tarihi</th>
                        <th>Durum</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointmentData as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->patient_name }}</td>
                            <td>{{ $appointment->doctor_name }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ $appointment->status }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="6">
                            <div class="d-flex">
                                {{ $appointments->links('pagination::bootstrap-4') }}  <!-- Paginator'dan gelen links() ile sayfalama bağlantılarını gösteriyoruz -->
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Bootstrap JS ve Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{asset("assets/js/log.js")}}"></script>
@endsection
