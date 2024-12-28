<footer id="footer" class="footer light-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="index.html" class="logo d-flex align-items-center">
                    <span class="sitename">ARAL</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>Yeşil Cami, Çanakkale</p>
                    <p class="mt-3"><strong>Telefon:</strong> <span>+90 500 00 00</span></p>
                    <p><strong>Mail:</strong> <span>lorem@ipsum.com</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Sayfalar</h4>
                <ul>
                    @foreach($pagesData as $data)
                        <li><a href="#{{$data->page_hash}}">{{$data->page_name}}<br></a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Hasta Bilgisi</h4>
                <ul>
                    <li><a href="#">Randevu Al</a></li>
                    <li><a href="#">Hasta Hakları</a></li>
                    <li><a href="#">Sık Sorulan Sorular</a></li>
                    <li><a href="#">Hasta Yorumları</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Sağlık Rehberi</h4>
                <ul>
                    <li><a href="#">Sağlık İpuçları</a></li>
                    <li><a href="#">Tedavi Yöntemleri</a></li>
                    <li><a href="#">Sağlık Blogu</a></li>
                    <li><a href="#">Bize Ulaşın</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Kurumsal</h4>
                <ul>
                    <li><a href="#">Kariyer Fırsatları</a></li>
                    <li><a href="#">Hastane Politikaları</a></li>
                    <li><a href="#">Sosyal Sorumluluk Projeleri</a></li>
                    <li><a href="#">Basın Bülteni</a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">ARAL</strong> <span>Tüm Haklar Saklıdır</span></p>
        <div class="credits">
        </div>
    </div>

</footer>
