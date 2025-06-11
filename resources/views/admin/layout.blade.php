<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ARAL - Admin Panel</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">

    <!-- Custom Admin CSS -->
    <link href="{{asset('assets/css/admin.css')}}" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="{{asset("assets/vendor/sweetalert2/dist/sweetalert2.min.css")}}" rel="stylesheet">
    <script src="{{asset("assets/vendor/sweetalert2/dist/sweetalert2.min.js")}}"></script>

    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #4338ca;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg);
            color: #334155;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: #ffffff;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            transition: all 0.3s ease;
            border-right: 1px solid var(--border-color);
        }

        .sidebar .navbar-brand {
            padding: 1.75rem;
        }

        .sidebar .navbar-nav .nav-link {
            padding: 0.875rem 1.75rem;
            color: #64748b;
            border-radius: 0.5rem;
            margin: 0.25rem 1rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .navbar-nav .nav-link:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .sidebar .navbar-nav .nav-link.active {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .sidebar .navbar-nav .nav-link i {
            width: 1.75rem;
            font-size: 1.1rem;
            margin-right: 0.75rem;
            text-align: center;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .sidebar .navbar-nav .nav-link:hover i {
            color: var(--primary-color);
            transform: translateX(2px);
        }

        .sidebar .navbar-nav .nav-link.active i {
            color: var(--primary-color);
        }

        /* Content Area */
        .content {
            margin-left: 280px;
            padding: 2.5rem;
            min-height: 100vh;
        }

        /* User Profile */
        .user-profile {
            padding: 1.75rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
            background: #f8fafc;
            border-radius: 0.5rem;
            margin: 0 1rem 1rem 1rem;
        }

        .user-profile .user-image {
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            color: white;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .user-profile .user-info h6 {
            margin: 0;
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
        }

        .user-profile .user-info span {
            font-size: 0.875rem;
            color: #64748b;
        }

        .user-profile .user-image i {
            font-size: 1.25rem;
            color: #ffffff;
        }

        /* Card Styles */
        .card {
            background: #ffffff;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            margin-bottom: 1.75rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.75rem;
            font-weight: 600;
            color: #1e293b;
            border-radius: 1rem 1rem 0 0 !important;
        }

        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            border-radius: 0.5rem;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        /* Table Styles */
        .table > :not(caption) > * > * {
            padding: 1rem 1.25rem;
        }

        .table thead th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #475569;
            border-bottom: 2px solid var(--border-color);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: -280px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .content {
                margin-left: 0;
                padding: 1.5rem;
            }
            .content.active {
                margin-left: 280px;
            }
        }

        /* Navbar Toggler */
        .navbar-toggler {
            padding: 0.625rem;
            font-size: 1.25rem;
            border: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1050;
            display: none;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        }

        @media (max-width: 991.98px) {
            .navbar-toggler {
                display: block;
            }
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .dark-mode-toggle:hover {
            transform: scale(1.1);
        }

        /* Loading Spinner */
        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #121212;
            color: #e5e7eb;
        }

        body.dark-mode .sidebar,
        body.dark-mode .card,
        body.dark-mode .navbar-toggler,
        body.dark-mode .content {
            background: #1e1e1e;
            border-color: #2d2d2d;
            color: #e5e7eb;
        }

        body.dark-mode .navbar-brand h3 {
            color: #e5e7eb !important;
        }

        body.dark-mode .sidebar {
            background: #1e1e1e;
            border-right: 1px solid #2d2d2d;
        }

        body.dark-mode .sidebar .navbar-nav .nav-link {
            color: #9ca3af;
        }

        body.dark-mode .sidebar .navbar-nav .nav-link:hover,
        body.dark-mode .sidebar .navbar-nav .nav-link.active {
            background-color: #2d2d2d;
            color: #ffffff;
        }

        body.dark-mode .user-profile {
            background: #2d2d2d;
            border-color: #404040;
        }

        body.dark-mode .user-profile .user-image {
            background: #4f46e5;
        }

        body.dark-mode .user-profile .user-image i {
            color: #ffffff;
        }

        body.dark-mode .user-info h6 {
            color: #ffffff;
        }

        body.dark-mode .user-info span {
            color: #a3a3a3;
        }

        body.dark-mode .card {
            background: #1e1e1e;
            border: 1px solid #2d2d2d;
        }

        body.dark-mode .card-header {
            background: #2d2d2d;
            border-color: #404040;
            color: #ffffff;
        }

        body.dark-mode .table {
            color: #e5e7eb;
            background: #1e1e1e;
        }

        body.dark-mode .table thead th {
            background-color: #2d2d2d;
            color: #ffffff;
            border-color: #404040;
        }

        body.dark-mode .table tbody tr {
            background-color: #1e1e1e;
        }

        body.dark-mode .table tbody tr:hover {
            background-color: #2d2d2d;
        }

        body.dark-mode .table td,
        body.dark-mode .table th {
            border-color: #404040;
        }

        body.dark-mode .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: #ffffff;
        }

        body.dark-mode .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }

        body.dark-mode .btn-secondary {
            background-color: #4b5563;
            border-color: #4b5563;
        }

        body.dark-mode .loading-spinner {
            background: rgba(0, 0, 0, 0.8);
        }

        body.dark-mode .spinner {
            border-color: #2d2d2d;
            border-top-color: #4f46e5;
        }

        body.dark-mode ::-webkit-scrollbar-track {
            background: #1e1e1e;
        }

        body.dark-mode ::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        body.dark-mode ::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        body.dark-mode .dataTables_wrapper {
            background: #1e1e1e;
            color: #e5e7eb;
        }

        body.dark-mode .dataTables_length,
        body.dark-mode .dataTables_filter,
        body.dark-mode .dataTables_info,
        body.dark-mode .dataTables_paginate {
            color: #e5e7eb !important;
        }

        body.dark-mode .dataTables_length select,
        body.dark-mode .dataTables_filter input {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #e5e7eb;
        }

        body.dark-mode .dataTables_length select option {
            background-color: #2d2d2d;
            color: #e5e7eb;
        }

        body.dark-mode .paginate_button {
            background: #2d2d2d !important;
            color: #e5e7eb !important;
            border: 1px solid #404040 !important;
        }

        body.dark-mode .paginate_button.current,
        body.dark-mode .paginate_button:hover {
            background: #4f46e5 !important;
            color: #ffffff !important;
            border: 1px solid #4338ca !important;
        }

        body.dark-mode .paginate_button.disabled {
            background: #1e1e1e !important;
            color: #6b7280 !important;
            border: 1px solid #2d2d2d !important;
        }

        body.dark-mode input::placeholder {
            color: #9ca3af;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #e5e7eb;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background-color: #2d2d2d;
            border-color: #4f46e5;
            color: #e5e7eb;
        }

        body.dark-mode .modal-content {
            background-color: #1e1e1e;
            border-color: #2d2d2d;
        }

        body.dark-mode .modal-header {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #ffffff;
        }

        body.dark-mode .modal-footer {
            border-color: #404040;
        }

        body.dark-mode .close {
            color: #e5e7eb;
        }

        body.dark-mode .badge {
            border: 1px solid #404040;
        }

        body.dark-mode .alert {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #e5e7eb;
        }

        /* Tooltip dark mode */
        body.dark-mode .tooltip .tooltip-inner {
            background-color: #2d2d2d;
            color: #e5e7eb;
        }

        body.dark-mode .tooltip .tooltip-arrow::before {
            border-top-color: #2d2d2d;
        }

        /* SweetAlert2 dark mode */
        body.dark-mode .swal2-popup {
            background-color: #1e1e1e;
            color: #e5e7eb;
        }

        body.dark-mode .swal2-title {
            color: #ffffff;
        }

        body.dark-mode .swal2-content {
            color: #e5e7eb;
        }

        body.dark-mode .swal2-actions button {
            background-color: #4f46e5;
            color: #ffffff;
        }

        body.dark-mode .swal2-styled.swal2-confirm {
            background-color: #4f46e5;
        }

        body.dark-mode .swal2-styled.swal2-cancel {
            background-color: #4b5563;
        }

        /* Table Styles Update */
        .table-responsive {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .dataTables_wrapper {
            width: 100%;
            margin: 0;
            padding: 1rem;
        }

        .dataTables_length select,
        .dataTables_filter input {
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            background-color: #fff;
            margin: 0 0.5rem;
        }

        body.dark-mode .dataTables_length select,
        body.dark-mode .dataTables_filter input {
            background-color: #333;
            border-color: #404040;
            color: #e5e7eb;
        }

        .dataTables_info,
        .dataTables_paginate {
            margin-top: 1rem;
        }

        .paginate_button {
            padding: 0.375rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 0.5rem;
            cursor: pointer;
        }

        .paginate_button.current {
            background-color: var(--primary-color);
            color: white;
        }

        body.dark-mode .paginate_button.current {
            background-color: var(--primary-color);
            color: white;
        }

        body.dark-mode .paginate_button {
            color: #e5e7eb !important;
        }

        body.dark-mode .paginate_button.disabled {
            color: #666 !important;
        }

        body.dark-mode .navbar-toggler i {
            color: #9ca3af;
        }

        body.dark-mode .dark-mode-toggle i {
            color: #ffffff;
        }

        body.dark-mode .navbar-brand h3.text-primary {
            color: var(--primary-color) !important;
        }
    </style>
</head>

<body>
    <!-- Loading Spinner -->
    <div class="loading-spinner">
        <div class="spinner"></div>
    </div>

    <!-- Sidebar Toggle Button -->
    <button class="navbar-toggler">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Dark Mode Toggle -->
    <div class="dark-mode-toggle" title="Karanlık/Aydınlık Mod">
        <i class="fas fa-moon"></i>
    </div>

    <div class="container-fluid position-relative d-flex p-0">
    <!-- Sidebar Start -->
        <div class="sidebar">
            <nav class="navbar">
                <a href="/" class="navbar-brand">
                    <h3 class="text-primary fw-bold m-0">ARAL</h3>
                </a>

                <div class="user-profile">
                    <div class="d-flex align-items-center">
                        <div class="user-image">
                            <i class="fas fa-user"></i>
                </div>
                        <div class="user-info ms-3">
                            <h6>{{Auth::user()->name}}</h6>
                    <span>{{$rol_name}}</span>
                        </div>
                </div>
            </div>

            <div class="navbar-nav w-100">
                @if($rol_id == 4)
                        <a href="/admin" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="/admin/log" class="nav-link {{ request()->is('admin/log') ? 'active' : '' }}">
                            <i class="fas fa-history"></i>
                            <span>Sistem Logları</span>
                        </a>
                        <a href="/admin/appointment" class="nav-link {{ request()->is('admin/appointment') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Randevular</span>
                        </a>
                        <a href="/admin/roles" class="nav-link {{ request()->is('admin/roles') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            <span>Kullanıcı Rolleri</span>
                        </a>
                @endif

                @if($rol_id == 1)
                        <a href="/doctor-panel" class="nav-link {{ request()->is('doctor-panel') ? 'active' : '' }}">
                            <i class="fas fa-stethoscope"></i>
                            <span>Doktor Paneli</span>
                        </a>
                @endif

                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Çıkış Yap</span>
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

    <!-- Core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        // Loading Spinner
        function showLoading() {
            document.querySelector('.loading-spinner').style.display = 'flex';
        }

        function hideLoading() {
            document.querySelector('.loading-spinner').style.display = 'none';
        }

        // Dark Mode Toggle
        const darkModeToggle = document.querySelector('.dark-mode-toggle');
        const body = document.body;
        const isDarkMode = localStorage.getItem('darkMode') === 'true';

        if (isDarkMode) {
            body.classList.add('dark-mode');
            darkModeToggle.querySelector('i').classList.replace('fa-moon', 'fa-sun');
        }

        darkModeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDark = body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark);
            
            const icon = darkModeToggle.querySelector('i');
            if (isDark) {
                icon.classList.replace('fa-moon', 'fa-sun');
            } else {
                icon.classList.replace('fa-sun', 'fa-moon');
            }
        });

        // Sidebar Toggle
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.content').classList.toggle('active');
        });

        // Responsive sidebar
        function checkWidth() {
            if (window.innerWidth <= 991.98) {
                document.querySelector('.sidebar').classList.remove('active');
                document.querySelector('.content').classList.remove('active');
            }
        }

        window.addEventListener('resize', checkWidth);
        checkWidth();

        // Page Loading
        window.addEventListener('load', hideLoading);
        window.addEventListener('beforeunload', showLoading);

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // DataTables Default Configuration
        $.extend(true, $.fn.dataTable.defaults, {
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
                },
                "aria": {
                    "sortAscending":  ": artan sütun sıralamasını aktifleştir",
                    "sortDescending": ": azalan sütun sıralamasını aktifleştir"
                }
            },
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], ['10', '25', '50', 'Tümü']],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            columnDefs: [
                {
                    targets: '_all',
                    className: 'text-center'
                }
            ]
        });
    </script>

@yield('js')
</body>

</html>
