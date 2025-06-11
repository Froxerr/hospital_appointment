@extends('admin.layout')

@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="mb-0 text-gray-600">Hastane yönetim sistemi genel durumu</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="text-gray-600">Son güncelleme: {{ now()->format('d.m.Y H:i') }}</span>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row">
        <!-- Doluluk Oranı Kartı -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Doluluk Oranı</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$occupancy_rate}}%</div>
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar" role="progressbar" style="width: {{$occupancy_rate}}%"
                                     aria-valuenow="{{$occupancy_rate}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bed fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yeni Hasta Kartı -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Yeni Hastalar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$getNewUser}}</div>
                            <div class="text-xs text-gray-500 mt-2">Bu ay kaydolan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktif Tedavi Kartı -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Aktif Tedaviler</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$getAppointmentCount}}</div>
                            <div class="text-xs text-gray-500 mt-2">Devam eden tedaviler</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toplam Randevu Kartı -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Toplam Randevular</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($appointmentDatas)}}</div>
                            <div class="text-xs text-gray-500 mt-2">Tüm randevular</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Son Randevular Tablosu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Son Randevular</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="appointmentsTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hasta</th>
                            <th>Doktor</th>
                            <th>Tarih</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointmentDatas as $appointmentData)
                            <tr>
                                <td>{{$appointmentData["id"]}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-title text-primary">
                                                {{substr($appointmentData["patient_name"], 0, 1)}}
                                            </span>
                                        </div>
                                        {{$appointmentData["patient_name"]}}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-title text-success">
                                                {{substr($appointmentData["doctor_name"], 0, 1)}}
                                            </span>
                                        </div>
                                        {{$appointmentData["doctor_name"]}}
                                    </div>
                                </td>
                                <td>{{$appointmentData["appointment_date"]}}</td>
                                <td>
                                    @php
                                        $statusClass = match($appointmentData["status"]) {
                                            'Beklemede' => 'badge bg-warning',
                                            'Tamamlandı' => 'badge bg-success',
                                            'İptal Edildi' => 'badge bg-danger',
                                            default => 'badge bg-secondary'
                                        };
                                    @endphp
                                    <span class="{{$statusClass}}">{{$appointmentData["status"]}}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .border-left-primary {
            border-left: 4px solid var(--primary-color) !important;
        }
        .border-left-success {
            border-left: 4px solid var(--success-color) !important;
        }
        .border-left-info {
            border-left: 4px solid var(--info-color) !important;
        }
        .border-left-warning {
            border-left: 4px solid var(--warning-color) !important;
        }
        .progress-bar {
            background-color: var(--primary-color);
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .text-gray-300 {
            color: #dddfeb !important;
        }
        .text-gray-500 {
            color: #858796 !important;
        }
        .text-gray-600 {
            color: #6e707e !important;
        }
        .text-gray-800 {
            color: #3a3b45 !important;
        }
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .table > :not(caption) > * > * {
            padding: 1rem;
        }
        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
        }

        /* Tablo genişlik ayarları */
        .table-responsive {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }

        @media (max-width: 1400px) {
            .table-responsive {
                width: 100%;
                margin-left: 0;
                margin-right: 0;
            }
        }

        @media (max-width: 992px) {
            .table-responsive {
                width: 100%;
                margin-left: 0;
                margin-right: 0;
            }
        }

        /* DataTables özelleştirmeleri */
        .dataTables_wrapper {
            width: 100%;
            padding: 1rem;
        }

        .dataTables_length,
        .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_info,
        .dataTables_paginate {
            margin-top: 1rem;
        }
    </style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#appointmentsTable')) {
            $('#appointmentsTable').DataTable({
                responsive: true,
                language: {
                    decimal: "",
                    emptyTable: "Tabloda herhangi bir veri mevcut değil",
                    info: "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
                    infoEmpty: "Kayıt yok",
                    infoFiltered: "(_MAX_ kayıt içerisinden bulunan)",
                    infoPostFix: "",
                    thousands: ",",
                    lengthMenu: "_MENU_ kayıt göster",
                    loadingRecords: "Yükleniyor...",
                    processing: "İşleniyor...",
                    search: "Ara:",
                    zeroRecords: "Eşleşen kayıt bulunamadı",
                    paginate: {
                        first: "İlk",
                        last: "Son",
                        next: "Sonraki",
                        previous: "Önceki"
                    }
                },
                order: [[0, 'desc']],
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
                columnDefs: [
                    {
                        targets: [0],
                        width: '5%'
                    },
                    {
                        targets: [1, 2],
                        width: '25%'
                    },
                    {
                        targets: [3],
                        width: '20%'
                    },
                    {
                        targets: [4],
                        width: '15%'
                    }
                ]
            });
        }
    });
</script>
@endsection
