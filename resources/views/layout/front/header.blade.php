<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:lorem@ipsum.com">lorem@ipsum.com</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+90 500 00 00</span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center me-auto">
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">ARAL</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    @foreach($pagesData as $data)
                        @if($data->page_hash == 'contact')
                            <!-- 'e' başlığına sadece contact sayfasında tıklanabilir -->
                            <li><a href="{{ url('/' . $data->page_hash) }}">{{$data->page_name}}</a></li>
                        @else
                            <!-- 'a', 'b', 'c', 'd' başlıklarına index sayfasında tıklanabilir -->
                            <li><a href="{{ url('/#' . $data->page_hash) }}">{{$data->page_name}}</a></li>
                        @endif
                    @endforeach
                </ul>


                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            @if(Auth::check())
                <!-- RANDEVU BUTTON -->
                @if($role_id == 1)
                    <a class="cta-btn d-none d-sm-block" href="/doctor-controller">Randevular</a>
                @else
                    <a class="cta-btn d-none d-sm-block" href="/appointment">Randevu Oluştur</a>
                    <a class="cta-btn d-none d-sm-block" href="/appointment-show" style="margin-left:15px">Randevularım</a>
                @endif
            @else
                <!-- LOGIN BUTTON -->
                <div class="ms-4"></div>
                <button class="login-button" style="--clr: #1977cc" onclick="window.location.href='/register'">
              <span class="login-button__icon-wrapper">
                <svg
                    viewBox="0 0 14 15"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    class="login-button__icon-svg"
                    width="10"
                >
                  <path
                      d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                      fill="currentColor"
                  ></path>
                </svg>

                <svg
                    viewBox="0 0 14 15"
                    fill="none"
                    width="10"
                    xmlns="http://www.w3.org/2000/svg"
                    class="login-button__icon-svg login-button__icon-svg--copy"
                >
                  <path
                      d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                      fill="currentColor"
                  ></path>
                </svg>
              </span>
                    Üye Ol
                </button>
        </div>
            @endif


    </div>



</header>
