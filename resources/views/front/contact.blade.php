@extends("front.layout")

@section("icerik")
    <main class="main">
        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>İletişim</h2>
                <p>Sorularınızı, önerilerinizi iletmek için iletişim kanallarımızı kullanabilirsiniz</p>
            </div><!-- End Section Title -->

            <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1176.327421723637!2d26.42059224216326!3d40.11965144870949!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b10756719b657f%3A0x65818bf6312e27b1!2s%C3%87OM%C3%9C%20Sosyal%20Bilimler%20Meslek%20Y%C3%BCksekokulu!5e0!3m2!1str!2str!4v1734103399051!5m2!1str!2str" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div><!-- End Google Maps -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">

                    <div class="col-lg-4">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Konum</h3>
                                <p>Yeşil Cami, Çanakkale</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Bizi Arayın</h3>
                                <p>+90 500 00 00</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Bize Mail Atın</h3>
                                <p>lorem@ipsum.com</p>
                            </div>
                        </div><!-- End Info Item -->

                    </div>

                    <div class="col-lg-8">
                        <form action="/contact" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="contact_name" class="form-control {{in_array("contact_name",$errors->keys()) ? "is-invalid" : " "}}" placeholder="Adınız" value="{{old("contact_name")}}" style="{{in_array("contact_name",$errors->keys()) ? "border-color:#ea868f;" : " "}}">
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control {{in_array("contact_email",$errors->keys()) ? "is-invalid" : " "}}" name="contact_email" placeholder="Mailiniz" value="{{old("contact_email")}}" style="{{in_array("contact_email",$errors->keys()) ? "border-color:#ea868f;" : " "}}">
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control {{in_array("contact_subject",$errors->keys()) ? "is-invalid" : " "}}" name="contact_subject" placeholder="Konu" value="{{old("contact_subject")}}" style="{{in_array("contact_subject",$errors->keys()) ? "border-color:#ea868f;" : " "}}">
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control {{in_array("contact_message",$errors->keys()) ? "is-invalid" : " "}}" name="contact_message" rows="6" placeholder="Mesajınız" style="{{in_array("contact_message",$errors->keys()) ? "border-color:#ea868f;" : " "}}">{{old("contact_message")}}</textarea>
                                </div>

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

                                <div class="col-md-12 text-center">
                                    <button type="submit">Mesajı Gönder</button>
                                </div>



                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->
    </main>
@endsection

