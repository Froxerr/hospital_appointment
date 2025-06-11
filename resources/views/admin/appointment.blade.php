@extends('admin.layout')
@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Randevu Geçmişi</h1>
            <p class="mb-0 text-gray-600">Tüm randevuları görüntüleyin ve yönetin</p>
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
                        <input type="text" class="form-control border-start-0" id="appointmentSearch" placeholder="Randevularda ara...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">Tüm Durumlar</option>
                        <option value="Beklemede">Beklemede</option>
                        <option value="Tamamlandı">Tamamlandı</option>
                        <option value="İptal Edildi">İptal Edildi</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" id="refreshAppointments">
                        <i class="fas fa-sync-alt me-2"></i> Yenile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Randevular Tablosu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Randevu Listesi</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="appointmentsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hasta</th>
                            <th>Doktor</th>
                            <th>Randevu Tarihi</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointmentData as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-title text-primary">
                                                {{substr($appointment->patient_name, 0, 1)}}
                                            </span>
                                        </div>
                                        {{ $appointment->patient_name }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-title text-success">
                                                <i class="fas fa-user-md"></i>
                                            </span>
                                        </div>
                                        {{ $appointment->doctor_name }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt text-info me-2"></i>
                                        {{ $appointment->appointment_date }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($appointment->status) {
                                            'Beklemede' => 'bg-warning',
                                            'Tamamlandı' => 'bg-success',
                                            'İptal Edildi' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{$statusClass}}">{{ $appointment->status }}</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-show-appointment" 
                                                data-id="{{ $appointment->id }}" title="Detaylar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-success btn-edit-appointment" 
                                                data-id="{{ $appointment->id }}" title="Düzenle">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-appointment" 
                                                data-id="{{ $appointment->id }}" title="Sil">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $appointments->links('pagination::bootstrap-4') }}
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
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
        .btn-group .btn i {
            font-size: 0.875rem;
        }
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
    </style>

    @section('js')
    <script>
        $(document).ready(function() {
            // CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // DataTables initialization
            if (!$.fn.DataTable.isDataTable('#appointmentsTable')) {
                $('#appointmentsTable').DataTable({
                    responsive: true,
                    language: {
                        "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                        "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                        "sInfoEmpty":      "Kayıt yok",
                        "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                        "sInfoPostFix":    "",
                        "sInfoThousands":  ".",
                        "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                        "sLoadingRecords": "Yükleniyor...",
                        "sProcessing":     "İşleniyor...",
                        "sSearch":         "Ara:",
                        "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                        "oPaginate": {
                            "sFirst":    "İlk",
                            "sLast":     "Son",
                            "sNext":     "Sonraki",
                            "sPrevious": "Önceki"
                        },
                        "oAria": {
                            "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                            "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                        },
                        "select": {
                            "rows": {
                                "_": "%d kayıt seçildi",
                                "0": "",
                                "1": "1 kayıt seçildi"
                            }
                        }
                    },
                    order: [[0, 'desc']],
                    pageLength: 10,
                    lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]]
                });
            }

            // Search functionality
            $('#appointmentSearch').on('keyup', function() {
                const table = $('#appointmentsTable').DataTable();
                table.search(this.value).draw();
            });

            // Filter functionality
            $('#statusFilter').on('change', function() {
                const table = $('#appointmentsTable').DataTable();
                table.column(4).search(this.value).draw();
            });

            // Refresh button functionality
            $('#refreshAppointments').on('click', function() {
                const button = $(this);
                const icon = button.find('i');

                button.prop('disabled', true);
                icon.addClass('fa-spin');

                setTimeout(function() {
                    location.reload();
                }, 1000);
            });

            // Detay görüntüleme
            $('.btn-show-appointment').on('click', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/admin/appointments/${id}`,
                    method: 'GET',
                    success: function(response) {
                        // Modal içeriğini oluştur
                        let modalContent = `
                            <div class="modal-body">
                                <h5 class="mb-3">Hasta Bilgileri</h5>
                                <p><strong>Ad Soyad:</strong> ${response.patient.name}</p>
                                <p><strong>E-posta:</strong> ${response.patient.email}</p>
                                <p><strong>Telefon:</strong> ${response.patient.phone}</p>
                                
                                <h5 class="mt-4 mb-3">Doktor Bilgileri</h5>
                                <p><strong>Ad Soyad:</strong> ${response.doctor.name}</p>
                                <p><strong>Uzmanlık:</strong> ${response.doctor.specialty}</p>
                                
                                <h5 class="mt-4 mb-3">Randevu Bilgileri</h5>
                                <p><strong>Tarih:</strong> ${response.appointment.date}</p>
                                <p><strong>Saat:</strong> ${response.appointment.time}</p>
                                <p><strong>Durum:</strong> <span class="badge ${response.appointment.status === 'Onaylandı' ? 'bg-success' : 'bg-danger'}">${response.appointment.status}</span></p>
                                <p><strong>Konum:</strong> ${response.appointment.location}</p>
                            </div>
                        `;

                        // SweetAlert2 ile göster
                        Swal.fire({
                            title: 'Randevu Detayları',
                            html: modalContent,
                            width: '600px',
                            showCloseButton: true,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire('Hata', 'Randevu detayları alınamadı', 'error');
                    }
                });
            });

            // Durum güncelleme
            $('.btn-edit-appointment').on('click', function() {
                const button = $(this);
                const row = button.closest('tr');
                const id = button.data('id');
                const currentStatus = row.find('.badge').text();

                Swal.fire({
                    title: 'Randevu Durumu Güncelle',
                    text: `Randevu durumunu "${currentStatus === 'Onaylandı' ? 'İptal' : 'Onaylandı'}" olarak değiştirmek istediğinize emin misiniz?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet, Güncelle',
                    cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/appointments/${id}`,
                            method: 'PUT',
                            success: function(response) {
                                if (response.success) {
                                    // Satırı güncelle
                                    const badge = row.find('.badge');
                                    if (response.status === 'Onaylandı') {
                                        badge.removeClass('bg-danger').addClass('bg-success');
                                    } else {
                                        badge.removeClass('bg-success').addClass('bg-danger');
                                    }
                                    badge.text(response.status);
                                    
                                    Swal.fire('Başarılı', response.message, 'success');
                                } else {
                                    Swal.fire('Hata', response.error || 'Bir hata oluştu', 'error');
                                }
                            },
                            error: function(xhr) {
                                console.error('Güncelleme Hatası:', xhr);
                                let errorMessage = 'Randevu durumu güncellenemedi';
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                Swal.fire('Hata', errorMessage, 'error');
                            }
                        });
                    }
                });
            });

            // Silme işlemi
            $('.btn-delete-appointment').on('click', function() {
                const button = $(this);
                const row = button.closest('tr');
                const id = button.data('id');

                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Bu randevu kaydını silmek istediğinize emin misiniz?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet, Sil',
                    cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/appointments/${id}`,
                            method: 'DELETE',
                            success: function(response) {
                                if (response.success) {
                                    // Satırı animasyonlu şekilde kaldır
                                    row.fadeOut(400, function() {
                                        row.remove();
                                    });
                                    Swal.fire('Silindi!', response.message, 'success');
                                } else {
                                    Swal.fire('Hata', response.error || 'Bir hata oluştu', 'error');
                                }
                            },
                            error: function(xhr) {
                                console.error('Silme Hatası:', xhr);
                                let errorMessage = 'Randevu silinemedi';
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                Swal.fire('Hata', errorMessage, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endsection
@endsection
