<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ARAL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('assets/css/admin.css')}}" rel="stylesheet">

    <!-- DataTables CSS (Tablolar için) -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="{{asset("assets/vendor/sweetalert2/dist/sweetalert2.min.css")}}" rel="stylesheet">
    <script src="{{asset("assets/vendor/sweetalert2/dist/sweetalert2.min.js")}}"></script>  <!-- SweetAlert2 burada en son -->

</head>

<body>
<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-light navbar-light">
            <a href="/" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary"><i class="me-2"></i>ARAL</h3>
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <i class="fas fa-user rounded-circle" style="font-size: 40px; width: 40px; height: 40px;"></i>
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0">{{Auth::user()->name}}</h6>
                    <span>{{$rol_name}}</span>
                </div>
            </div>

            <div class="navbar-nav w-100">
                @if($rol_id == 4)
                    <a href="/admin" class="nav-item nav-link {{ request()->is('admin') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i>Anasayfa</a>
                    <a href="/admin/log" class="nav-item nav-link {{ request()->is('admin/log') ? 'active' : '' }}"><i class="fas fa-file-alt me-2"></i>Loglar</a>
                    <a href="/admin/appointment" class="nav-item nav-link {{ request()->is('admin/appointment') ? 'active' : '' }}"><i class="fas fa-calendar-check me-2"></i>Randevu Geçmişi</a>
                    <a href="/admin/roles" class="nav-item nav-link {{ request()->is('admin/roles') ? 'active' : '' }}"><i class="fas fa-user-tag me-2"></i>Roller</a>
                @endif
                @if($rol_id == 1)
                    <a href="/doctor-controller" class="nav-item nav-link {{ request()->is('doctor-controller') ? 'active' : '' }}"><i class="fas fa-calendar-alt me-2"></i>Randevu</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-item nav-link cikis {{ request()->is('logout') ? 'active' : '' }}" style="border: none; background-color: #f3f6f9;">
                        <i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap
                    </button>
                </form>
            </div>
        </nav>
    </div>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        @yield('content')
    </div>
    <!-- Content End -->
</div>

<!-- jQuery ve DataTables JS dosyalarını doğru sırayla yükleyin -->
@yield('js')

</body>

</html>
