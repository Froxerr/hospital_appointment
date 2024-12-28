<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>ARAL RANDEVU</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->

    <link href="{{asset("assets/img/favicon.png")}}" rel="icon">
    <link href="{{asset("assets/img/apple-touch-icon.png")}}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset("assets/vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/bootstrap-icons/bootstrap-icons.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/aos/aos.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/fontawesome-free/css/all.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/glightbox/css/glightbox.min.css")}}" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="{{asset("assets/vendor/sweetalert2/dist/sweetalert2.min.css")}}" rel="stylesheet">
    <script src="{{asset("assets/vendor/sweetalert2/dist/sweetalert2.min.js")}}"></script>  <!-- SweetAlert2 burada en son -->

    <!-- toastr css -->
    <link href="{{asset("assets/vendor/toastr/build/toastr.min.css")}}" rel="stylesheet">
    <script src="{{asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>

    <!-- Main CSS File -->
    <link href="{{asset("assets/css/main.css")}}" rel="stylesheet">

</head>



<body class="index-page">
    @include('layout.front.header')


    @yield('icerik')

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>
    @if (isset($showFooter) && $showFooter)
        @include('layout.front.footer')
    @endif

<!-- Vendor JS Files -->
    <script src="{{asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("assets/vendor/aos/aos.js")}}"></script>
    <script src="{{asset("assets/vendor/glightbox/js/glightbox.min.js")}}"></script>

    <script src="{{asset("assets/vendor/toastr/build/toastr.min.js")}}"></script>



<!-- Main JS File -->
<script src="{{asset("assets/js/main.js")}}"></script>
@yield('js')

</body>

</html>
