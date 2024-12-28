@extends('admin.layout')
@section('content')
    <div class="container mt-5 mx-auto">
    <div class="card ">
            <div class="card-header">
                <h3 class="hospital-dashboard-title">Kullanıcı Rolleri Yönetimi</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Ad Soyad</th>
                        <th>Mevcut Rol</th>
                        <th>Yeni Rol</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}} {{$user->surname}}</td>
                        @foreach($rolesDatas as $roleid)
                            @php
                            $userRoleName = "";
                                if($user->role_id == $roleid->role_id)
                                    $userRoleName = $roleid->role_name;
                                else
                                    continue;
                            @endphp
                        <td>{{$userRoleName}}</td>
                        @endforeach
                        <form action="/admin/roles" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <td>
                                <select class="form-select" name="role_id" id="roleSelect_{{$user->id}}">
                                    @foreach($rolesDatas as $role)
                                        <option value="{{$role->role_id}}">{{$role->role_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            @if(session('swal_message'))
                                <script>
                                    Swal.fire({
                                        icon: '{{ session('swal_type') }}',
                                        title: '{{ session('swal_message') }}',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                </script>
                            @endif
                            <td class="action-buttons">
                                <button class="btn role-btn">Güncelle</button>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6">
                            <div class="d-flex">
                                {{ $users->links('pagination::bootstrap-4') }}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
