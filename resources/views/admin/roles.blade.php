@extends('admin.layout')
@section('content')
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Kullanıcı Rolleri</h1>
            <p class="mb-0 text-gray-600">Kullanıcı yetkilerini ve rollerini yönetin</p>
        </div>
    </div>

    <!-- Roller Tablosu -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Kullanıcı Rolleri Listesi</h6>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="rolesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kullanıcı</th>
                            <th>Mevcut Rol</th>
                            <th>Yeni Rol</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle me-2">
                                            <span class="avatar-title text-primary">
                                                {{substr($user->name, 0, 1)}}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{$user->name}} {{$user->surname}}</h6>
                                        </div>
                                    </div>
                                </td>
                                @foreach($rolesDatas as $roleid)
                                    @php
                                        $userRoleName = "";
                                        if($user->role_id == $roleid->role_id)
                                            $userRoleName = $roleid->role_name;
                                        else
                                            continue;
                                    @endphp
                                    <td>
                                        <span class="badge bg-info">{{$userRoleName}}</span>
                                    </td>
                                @endforeach
                                <form action="/admin/roles" method="POST" class="role-update-form">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <td>
                                        <select class="form-select form-select-sm" name="role_id" id="roleSelect_{{$user->id}}">
                                            @foreach($rolesDatas as $role)
                                                <option value="{{$role->role_id}}" {{$user->role_id == $role->role_id ? 'selected' : ''}}>
                                                    {{$role->role_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-sync-alt me-1"></i> Güncelle
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <style>
        .form-select-sm {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }
        .role-update-form {
            display: contents;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }
        .badge {
            font-size: 0.875rem;
            padding: 0.5em 0.8em;
        }
    </style>

    @if(session('swal_message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{{ session('swal_type') }}',
                    title: '{{ session('swal_message') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        popup: 'animated fadeInDown faster'
                    }
                });
            });
        </script>
    @endif

    @section('js')
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#rolesTable')) {
                $('#rolesTable').DataTable({
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
        });
    </script>
    @endsection
@endsection
