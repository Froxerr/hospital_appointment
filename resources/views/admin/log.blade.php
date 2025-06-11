@extends('admin.layout')
@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Sistem Logları</h1>
            <p class="mb-0 text-gray-600">Sistem aktivitelerini ve olaylarını takip edin</p>
        </div>
        <div class="d-flex align-items-center">
            <span class="text-gray-600">Son güncelleme: {{ now()->format('d.m.Y H:i') }}</span>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="card shadow mb-4">
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-gray-500"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="logSearch" placeholder="Loglarda ara...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="logFilter">
                        <option value="">Tüm Kayıtlar</option>
                        <option value="info">Bilgi</option>
                        <option value="error">Hata</option>
                        <option value="warning">Uyarı</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" id="refreshLogs">
                        <i class="fas fa-sync-alt me-2"></i> Yenile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Tablosu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Sistem Aktiviteleri</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="logsTable">
                    <thead>
                        <tr>
                            <th>Tarih/Saat</th>
                            <th>Kullanıcı</th>
                            <th>E-posta</th>
                            <th>İşlem</th>
                            <th>IP Adresi</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($log_data as $log)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-gray-500 me-2"></i>
                                        {{$log->log_date}}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-title text-primary">
                                                {{substr($log->user_name, 0, 1)}}
                                            </span>
                                        </div>
                                        {{$log->user_name}}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-gray-500 me-2"></i>
                                        {{$log->user_email}}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-wrap" style="max-width: 300px;">
                                        {{$log->log_description}}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-network-wired text-gray-500 me-2"></i>
                                        {{$log->ip_address}}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($log->badge) {
                                            'info' => 'bg-info',
                                            'error' => 'bg-danger',
                                            'warning' => 'bg-warning',
                                            default => 'bg-secondary'
                                        };
                                        $badgeText = match($log->badge) {
                                            'info' => 'Bilgi',
                                            'error' => 'Hata',
                                            'warning' => 'Uyarı',
                                            default => 'Bilinmiyor'
                                        };
                                    @endphp
                                    <span class="badge {{$badgeClass}}">{{$badgeText}}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $log_data->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <style>
        .input-group-text {
            color: #6e707e;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }
        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
        }
        .text-wrap {
            white-space: normal;
            word-wrap: break-word;
        }
    </style>

    @section('js')
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#logsTable')) {
                $('#logsTable').DataTable({
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
                    lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]]
                });
            }

            // Search functionality
            $('#logSearch').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Filter functionality
            $('#logFilter').on('change', function() {
                const filterValue = $(this).val();
                table.column(5).search(filterValue).draw();
            });

            // Refresh button functionality
            $('#refreshLogs').on('click', function() {
                const button = $(this);
                const icon = button.find('i');
                
                button.prop('disabled', true);
                icon.addClass('fa-spin');

                setTimeout(function() {
                    location.reload();
                }, 1000);
            });
        });
    </script>
    @endsection
@endsection
