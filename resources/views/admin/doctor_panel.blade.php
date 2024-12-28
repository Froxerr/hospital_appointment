@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12">
                <h3 class="text-center hospital-dashboard-title">Randevular</h3>

                <div class="d-flex justify-content-between mb-3">
                    <!-- Filtreleme -->
                    <select class="form-select w-25" id="logFilter">
                        <option value="">Filtrele (Tümünü Göster)</option>
                        <option value="date">Tarih Artan</option>
                        <option value="date_desc">Tarih Azalan</option>
                        <option value="status">Onaylandı Olanları Göster</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered log-table">
                        <thead>
                        <tr>
                            <th>Randevu Id</th>
                            <th>Ad Soyad</th>
                            <th>Tarih</th>
                            <th>Saat</th>
                            <th>Randevu Durumu</th>
                        </tr>
                        </thead>
                        <tbody id="logTableBody">
                        @foreach($doctorData as $data)
                            <tr>
                                <td>{{$data->id}}</td>
                                <td>{{$data->patient_name}}</td>
                                <td>{{$data->appointment_date}}</td>
                                <td>{{$data->appointment_time}}</td>
                                <td>{{$data->status}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $doctorData->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Bootstrap JS ve Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>


    <!-- Doctor Panel JS -->
    <script src="{{ asset('assets/js/doctor_panel.js') }}"></script>
@endsection
