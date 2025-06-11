@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12">
                <h3 class="text-center hospital-dashboard-title">Randevular</h3>

                <div class="d-flex justify-content-between mb-3">
                    <!-- Filtreleme -->
                    <select class="form-select w-25" id="statusFilter">
                        <option value="all">Tüm Randevular</option>
                        <option value="confirmed">Onaylanan Randevular</option>
                        <option value="cancelled">İptal Edilen Randevular</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>Randevu No</th>
                                <th>Hasta</th>
                                @if($rol_id == 4)
                                    <th>Doktor</th>
                                @endif
                                <th>Tarih</th>
                                <th>Saat</th>
                                <th>Bölüm</th>
                                <th>Konum</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctorData as $data)
                                <tr>
                                    <td>{{ $data['id'] }}</td>
                                    <td>{{ $data['patient_name'] }}</td>
                                    @if($rol_id == 4)
                                        <td>{{ $data['doctor_name'] }}</td>
                                    @endif
                                    <td>{{ $data['date'] }}</td>
                                    <td>{{ $data['time'] }}</td>
                                    <td>{{ $data['specialty'] }}</td>
                                    <td>{{ $data['location'] }}</td>
                                    <td>
                                        <span class="badge {{ $data['status'] === 'Onaylandı' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $data['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // DataTables initialization
    var table = $('#appointmentsTable').DataTable({
        responsive: true,
        order: [[3, 'desc'], [4, 'desc']], // Tarih ve saat sütunlarına göre sırala
        language: {
            "emptyTable":     "Tabloda herhangi bir veri mevcut değil",
            "info":           "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "infoEmpty":      "Kayıt yok",
            "infoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
            "infoPostFix":    "",
            "thousands":      ".",
            "lengthMenu":     "Sayfada _MENU_ kayıt göster",
            "loadingRecords": "Yükleniyor...",
            "processing":     "İşleniyor...",
            "search":         "Ara:",
            "zeroRecords":    "Eşleşen kayıt bulunamadı",
            "paginate": {
                "first":      "İlk",
                "last":       "Son",
                "next":       "Sonraki",
                "previous":   "Önceki"
            }
        }
    });

    // Status filter functionality
    $('#statusFilter').on('change', function() {
        var status = $(this).val();
        
        if (status === 'all') {
            table.column(7).search('').draw();
        } else if (status === 'confirmed') {
            table.column(7).search('Onaylandı').draw();
        } else if (status === 'cancelled') {
            table.column(7).search('İptal').draw();
        }
    });
});
</script>
@endsection
