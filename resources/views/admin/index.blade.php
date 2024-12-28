@extends('admin.layout')

@section('content')

    <div class="col-10 p-4">
        <!-- Dashboard Başlık -->
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="hospital-dashboard-title">Hastane Yönetim Paneli</h2>
            <div class="d-flex align-items-center">
                <span class="me-3">Hoş geldiniz, <span class="hospital-dashboard-title" style="font-size: 20px; color:#0dcaf0;">{{Auth::user()->name}}</span></span>
            </div>
        </div>

        <!-- Genel İstatistikler -->
        <div class="row mt-4">
            <!-- Doluluk Durumu -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Doluluk Durumu</h5>
                        <p class="card-text">{{$occupancy_rate}}% Dolu</p>
                        <i class="fas fa-bed card-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Yeni Hastalar -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Yeni Hastalar</h5>
                        <p class="card-text">{{$getNewUser}} Yeni Kayıt</p>
                        <i class="fas fa-user-injured card-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Tedavi Altında Olanlar -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Tedavi Altındaki Hastalar</h5>
                        <p class="card-text">{{$getAppointmentCount}} Kişi</p>
                        <i class="fas fa-stethoscope card-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tablo (Veritabanı Verileri) -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Son Randevular</h5>
            </div>
            <div class="card-body">
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
                    @foreach($appointmentDatas as $appointmentData)
                    <tr>
                        <td>{{$appointmentData["id"]}}</td>
                        <td>{{$appointmentData["patient_name"]}}</td>
                        <td>{{$appointmentData["doctor_name"]}}</td>
                        <td>{{$appointmentData["appointment_date"]}}</td>
                        <td>{{$appointmentData["status"]}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
@endsection
