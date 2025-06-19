<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Internship</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="{{ asset('assets/invent/assets/img/favicon.png')}}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/invent/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/invent/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/invent/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/invent/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/invent/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/invent/assets/css/main.css') }}" rel="stylesheet">
  </head>
  <body class="index-page">
    <main class="main">
      <section id="contact" class="contact section" style="padding: 50px">
        <div class="container section-title" data-aos="fade-up">
          <h2>Pendaftaran Internship</h2>
          @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
          <div class="row">
            <div class="col-lg-12">
              <div class="form-wrapper" data-aos="fade-up" data-aos-delay="400">
                <form method="POST" action="{{ route('createAkun') }}">
                  @csrf
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap*" required="" autocomplete="off" value="Yossandi imran">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-star"></i></span>
                        <input type="text" name="asal_sekolah" class="form-control" placeholder="Asal Sekolah*" required="" autocomplete="off" value="STT Mandala Bandung">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-list"></i></span>
                        <input type="text" name="jurusan" class="form-control" placeholder="Jurusan*" required="" autocomplete="off" value="Teknik Informatika">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-copy"></i></span>
                        <input type="text" name="nim" class="form-control" placeholder="NIM*" required="" autocomplete="off" value="2041105">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Username*" required="" autocomplete="off" value="yossandiimran">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" name="email" placeholder="Email address*" required="" autocomplete="off" value="yossandiimran02@gmail.com">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                        <input type="number" class="form-control" name="no_hp" placeholder="Nomor HP*" required="" autocomplete="off" value="08123456789">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Password*" required="" autocomplete="off" value="Admin1234%">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="text-center">
                    <button type="submit">Daftar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>                
        </div>
      </section>
    </main>
    <footer id="footer" class="footer light-background">
      <div class="container footer-top">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="index.html" class="logo d-flex align-items-center">
              <span class="sitename">PT WIKA</span>
            </a>
            <div class="footer-contact pt-3">
              <p>Jl. Penakir</p>
              <p>Jawa Barat, Majalengka 535022</p>
              <p class="mt-3">
                <strong>Phone:</strong>
                <span>+628 1254 8888</span>
              </p>
              <p>
                <strong>Email:</strong>
                <span>info.wika-internship@gmail.com</span>
              </p>
            </div>
            <div class="social-links d-flex mt-4">
              <a href="">
                <i class="bi bi-twitter-x"></i>
              </a>
              <a href="">
                <i class="bi bi-facebook"></i>
              </a>
              <a href="">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="">
                <i class="bi bi-linkedin"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span>
          <strong class="px-1 sitename">WIKA</strong>
          <span>All Rights Reserved</span>
        </p>
      </div>
    </footer>
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
      <i class="bi bi-arrow-up-short"></i>
    </a>
    <!-- Preloader -->
    <div id="preloader"></div>
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/invent/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/invent/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{ asset('assets/invent/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('assets/invent/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('assets/invent/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets/invent/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('assets/invent/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('assets/invent/assets/js/main.js')}}"></script>
  </body>
</html>