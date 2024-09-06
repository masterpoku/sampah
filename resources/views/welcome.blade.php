<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SISTEM KELOLA SAMPAH UYP IOT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Abdul Rohman & Aditya Kesuma - IoT Engineer" name="keywords">
    <meta
        content="Sistem Kelola Monitoring dan Control Sampah Menjadi BBM Metode IOT berbasis web dan Mobile karya Abdul Rohman"
        name="description">
    <link href="{{ asset('template1/landing/img/deskripsi.png') }}" rel="icon">
    <link href="{{ asset('template1/landing/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('template1/landing/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template1/landing/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template1/landing/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template1/landing/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template1/landing/lib/magnific-popup/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('template1/landing/css/style.css') }}" rel="stylesheet">
</head>
<body">
    <header id="header">
        <div class="container">
            <div id="logo" class="pull-left">
                <h1><a href="#intro" class="scrollto">SAMPAHBBMIOT</a></h1>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="#intro">Beranda</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section id="intro">
        <div class="intro-text">
            <h2>Selamat datang di Sistem Sampah UYP IOT</h2>
            <p>Proyek Sistem Kelola Monitoring dan Control Sampah Menjadi BBM Metode IOT</p>
            <a href="{{ route('login') }}" class="btn-get-started scrollto">Login</a>
        </div>
        <div class="product-screens">
            <div class="product-screen-1 wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="0.6s">
                <img src="{{ asset('template1/landing/img/original.png') }}" alt="">
            </div>
            <div class="product-screen-2 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.6s">
                <img src="{{ asset('template1/landing/img/Monitoring and control.png') }}" alt="">
            </div>
            <div class="product-screen-3 wow fadeInUp" data-wow-duration="0.6s">
                <img src="{{ asset('template1/landing/img/Device.png') }}" alt="">
            </div>
        </div>
    </section>
    <main id="main">
        <section id="about" class="section-bg">
            <div class="container-fluid">
                <div class="section-header">
                    <h3 class="section-title">Tentang IoT Project </h3>
                    <span class="section-divider"></span>
                    <p class="section-description">
                        "Teknologi untuk semesta"
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-6 about-img wow fadeInLeft">
                        <img src="{{ asset('template1/landing/img/deskripsi.png') }}" alt="">
                    </div>
                    <div class="col-lg-6 content wow fadeInRight">
                        <h2>Deskripsi Singkat</h2>
                        <h3>http://iot-project.laurensius-dede-suhardiman.com</h3>
                        <p>
                            Halo, perkenalkan nama saya Aditya Kesuma dan Abdul Rohman dari Kota Tangerng, Banten.
                            IoT Project adalah proyek pribadi yang kami kerjakan sebagai bentuk penyaluran hobby.
                            Namun, disamping itu kami memiliki impian bahwa proyek ini dapat dikembangkan dan dapat
                            bermanfaat bagi masayarakat secara umum.
                            Fitur yang tersedia pada proyek ini antara lain :
                        </p>
                        <ul>
                            <li><i class="ion-android-checkmark-circle"></i> Monitoring suhu dan Control.</li>
                            <li><i class="ion-android-checkmark-circle"></i> Visualisasi data ke dalam grafik.</li>
                            <li><i class="ion-android-checkmark-circle"></i> Penyimpanan data dari sensor ke dalam
                                database.</li>
                            <li><i class="ion-android-checkmark-circle"></i> Mencetak Hasil Dari Monitoring Dan Control.
                            </li>
                        </ul>
                        <p>
                            Salam,
                        </p>
                        <p></p>
                        <p>
                            <b>Abdul Rohman & Aditya Kesuma</b>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section id="call-to-action">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 text-center text-lg-left">
                        <h3 class="cta-title">Download</h3>
                        <p class="cta-text">Dapatkan Aplikasi IoT Project untuk Android. Pantau suhu dan kelembaban dari
                            perangkat Android.</p>
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="#">Download</a>
                    </div>
                </div>
            </div>
        </section>
        <section id="clients">
            <div class="container">
                <div class="section-header">
                    <h3 class="section-title">Teknologi yang digunakan</h3>
                    <span class="section-divider"></span>
                </div>
                <div class="row wow fadeInUp">
                    <div class="col-md-3">
                        <img src="{{ asset('template1/landing/img/clients/codeigniter.png') }}" alt="">
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('template1/landing/img/clients/arduino.png') }}" alt="">
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('template1/landing/img/clients/esp8266.png') }}" alt="">
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('template1/landing/img/clients/mysql.png') }}" alt="">
                    </div>
                </div>
            </div>
        </section>
        <section id="contact">
            <div class="container">
                <div class="row wow fadeInUp">
                    <div class="col-lg-3 col-md-3">
                        <div class="contact-about">
                            <h3>IoT Project</h3>
                            <p>Untuk menyampaikan pertanyaan, saran, kritik, diskusi maupun proyek, Anda dapat
                                menghubungi kami melalui kontak dan media sosial yang tersedia. Terima kasih.</p>
                            <div class="social-links">
                                <a target="_blank" href="https://twitter.com/renzcybermedia" class="twitter"><i
                                        class="fa fa-twitter"></i></a>
                                <a target="_blank" href="https://facebook.com/saya.laurensius" class="facebook"><i
                                        class="fa fa-facebook"></i></a>
                                <a target="_blank" href="https://instagram.com/laurensius" class="instagram"><i
                                        class="fa fa-instagram"></i></a>
                                <a target="_blank" href="https://plus.google.com/u/1/+LaurensiusDS?hl=id"
                                    class="google-plus"><i class="fa fa-google-plus"></i></a>
                                <a target="_blank" href="https://www.linkedin.com/in/laurensiusds/"
                                    class="linkedin"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="info">
                            <div>
                                <i class="ion-ios-location-outline"></i>

                                <p>Kampung Kelor <br>RT 003 RW 003 Kampung Kelor, Sepatan Timur <br> Tangerang Regency,
                                    Banten 15520 </p>
                            </div>
                            <div>
                                <i class="ion-ios-email-outline"></i>
                                <p>arsylrahman8@gmail.com atau <br> abdul.rohman@ft-umt.ac.id</p>
                            </div>
                            <div>
                                <i class="ion-ios-telephone-outline"></i>
                                <p>Whatsapp +6285157366973

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <iframe
                            src="https://maps.google.com/maps?width=548&amp;height=353&amp;hl=en&amp;q=TheMagic&amp;t=p&amp;z=18&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                            width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-lg-left text-center">
                    <div class="copyright">
                        &copy; Copyright <strong><a href="http://laurensius-dede-suhardiman.com/"
                                target="_blank">Abdul Rohman & Aditya Kesuma </a></strong>.
                    </div>
                    <div class="credits">
                        <!-- Thanks to <a href="https://bootstrapmade.com/" target="_blank">BootstrapMade</a> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- <nav class="footer-links text-lg-right text-center pt-2 pt-lg-0">
            <a href="#intro" class="scrollto">Home</a>
            <a href="#about" class="scrollto">About</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Use</a>
          </nav> -->
                </div>
            </div>
        </div>
    </footer>
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <script src="{{ asset('template1/landing/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template1/landing/lib/jquery/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('template1/landing/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template1/landing/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('template1/landing/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('template1/landing/lib/superfish/hoverIntent.js') }}"></script>
    <script src="{{ asset('template1/landing/lib/superfish/superfish.min.js') }}"></script>
    <script src="{{ asset('template1/landing/lib/magnific-popup/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('template1/landing/contactform/contactform.js') }}"></script>
    <script src="{{ asset('template1/landing/js/main.js') }}"></script>

    </body>

</html>
