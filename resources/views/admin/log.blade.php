@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Navbar veya Sidebar buraya eklenebilir -->
        <div class="row mt-4">
            <div class="col-12">
                <h3 class="text-center hospital-dashboard-title">Loglar</h3>

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

                <!-- Loglar Tablosu -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered log-table">
                        <thead>
                        <tr>
                            <th>Tarih</th>
                            <th>Kullanıcı Adı</th>
                            <th>Kullanıcı E-posta</th>
                            <th>Mesaj</th>
                            <th>IP Adresi</th>
                            <th>Tür</th>
                        </tr>
                        </thead>
                        <tbody id="logTableBody">
                        @foreach($log_data as $log)
                            <tr>
                                <td>{{$log->log_date}}</td>
                                <td>{{$log->user_name}}</td>
                                <td>{{$log->user_email}}</td>
                                <td>{{$log->log_description}}</td>
                                <td>{{$log->ip_address}}</td>
                                <td><span class="badge bg-{{$log->badge}}">{{$log->badge == "info" ? "Bilgilendirme" : "Hata"}}</span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6">
                                <div class="d-flex">
                                    {{ $log_data->links('pagination::bootstrap-4') }}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
