<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Internship</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="assets/img/favicon.png" rel="icon">
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
    <header id="header" class="header d-flex align-items-center fixed-top">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
          <h1 class="sitename">Wika Internship</h1>
          <span>.</span>
        </a>
        <nav id="navmenu" class="navmenu">
          <ul>
            <li>
              <a href="#hero" class="active">Home</a>
            </li>
            <li>
              <a href="#services">Alur Pendaftaran</a>
            </li>
            <li>
              <a href="#faq">Faq</a>
            </li>
            <li>
              <a href="#testimonials">Alumni</a>
            </li>
            <li>
              <a href="#contact">Kontak</a>
            </li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="btn-getstarted" href="#about">Sign In</a>
      </div>
    </header>
    <main class="main">
      <!-- Hero Section -->
      <section id="hero" class="hero section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
              <div class="badge-wrapper mb-3">
                <div class="d-inline-flex align-items-center rounded-pill border border-accent-light">
                  <div class="icon-circle me-2">
                    <i class="bi bi-bell"></i>
                  </div>
                  <span class="badge-text me-3">Internship</span>
                </div>
              </div>
              <h1 class="hero-title mb-4">Platfrom khusus internship PT.Wika</h1>
              <p class="hero-description mb-4">"Selamat datang di platform informasi internship PT WIKA, tempat kami membantu mahasiswa dan siswa SMK menjalani magang dengan lebih terarah, terstruktur, dan transparan."</p>
              <div class="cta-wrapper">
                <a href="#" class="btn btn-primary">Daftar</a>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="hero-image">
                <img src="{{ asset('assets/invent/assets/img/illustration/illustration-16.webp')}}" alt="Business Growth" class="img-fluid" loading="lazy">
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="services" class="how-we-work section">
        <div class="container section-title" data-aos="fade-up">
          <h2>Alur Pendaftaran Internship</h2>
          <p>Berikut langkah-langkah untuk menjadi bagian dari program internship kami.</p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="steps-5">
            <div class="process-container">
              <div class="process-item" data-aos="fade-up" data-aos-delay="200">
                <div class="content">
                  <span class="step-number">01</span>
                  <div class="card-body">
                    <div class="step-icon">
                      <i class="bi bi-pencil-square"></i>
                    </div>
                    <div class="step-content">
                      <h3>Surat Pengantar dari Instansi Pendidikan</h3>
                      <p>Pastikan kamu membawa surat pengantar atau rekomendasi resmi dari kampus/sekolah sebagai bukti bahwa kamu adalah peserta magang yang sah.</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Process Item -->
              <div class="process-item" data-aos="fade-up" data-aos-delay="300">
                <div class="content">
                  <span class="step-number">02</span>
                  <div class="card-body">
                    <div class="step-icon">
                      <i class="bi bi-gear"></i>
                    </div>
                    <div class="step-content">
                      <h3>Pendaftaran & Pembuatan Akun</h3>
                      <p>Buat akun internship kamu melalui website ini untuk mengakses seluruh fitur dan proses administrasi. <br>*Catatan: Pastikan email yang digunakan aktif dan valid ya! </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Process Item -->
              <div class="process-item" data-aos="fade-up" data-aos-delay="400">
                <div class="content">
                  <span class="step-number">03</span>
                  <div class="card-body">
                    <div class="step-icon">
                      <i class="bi bi-search"></i>
                    </div>
                    <div class="step-content">
                      <h3>Verifikasi & Penerimaan</h3>
                      <p>Tim kami akan memverifikasi dokumen dan data kamu. Jika sesuai, kamu akan resmi diterima sebagai peserta internship.</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Process Item -->
              <div class="process-item" data-aos="fade-up" data-aos-delay="500">
                <div class="content">
                  <span class="step-number">04</span>
                  <div class="card-body">
                    <div class="step-icon">
                      <i class="bi bi-rocket-takeoff"></i>
                    </div>
                    <div class="step-content">
                      <h3>Penilaian & Sertifikat</h3>
                      <p>Setelah menyelesaikan masa internship sesuai ketentuan, kamu akan mendapatkan penilaian serta sertifikat resmi dari PT WIKA sebagai bukti pengalaman magangmu.</p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Process Item -->
            </div>
          </div>
        </div>
      </section>
      <!-- /How We Work Section -->
      <!-- Faq Section -->
      <section id="faq" class="faq section">
         <div class="container" data-aos="fade-up" data-aos-delay="100">
           <div class="row gy-5">
       
             <!-- Kartu Kontak -->
             <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
               <div class="faq-contact-card">
                 <div class="card-icon">
                   <i class="bi bi-question-circle"></i>
                 </div>
                 <div class="card-content">
                   <h3>Masih Punya Pertanyaan?</h3>
                   <p>Jika kamu masih memiliki pertanyaan seputar program internship di PT WIKA, jangan ragu untuk menghubungi kami melalui opsi kontak berikut. Kami siap membantu kamu!</p>
                   <div class="contact-options">
                     <a href="mailto:internship@wika.co.id" class="contact-option">
                       <i class="bi bi-envelope"></i>
                       <span>Email Support</span>
                     </a>
                     <a href="#" class="contact-option">
                       <i class="bi bi-chat-dots"></i>
                       <span>Live Chat</span>
                     </a>
                     <a href="tel:+621234567890" class="contact-option">
                       <i class="bi bi-telephone"></i>
                       <span>Hubungi Kami</span>
                     </a>
                   </div>
                 </div>
               </div>
             </div>
       
             <!-- FAQ Accordion -->
             <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
               <div class="faq-accordion">
       
                 <div class="faq-item faq-active">
                   <div class="faq-header">
                     <h3>Apa saja syarat mengikuti program internship?</h3>
                     <i class="bi bi-chevron-down faq-toggle"></i>
                   </div>
                   <div class="faq-content">
                     <p>Kamu perlu memiliki surat pengantar atau rekomendasi dari institusi pendidikan (kampus/SMK) serta membuat akun pada sistem kami untuk mengakses alur dan fitur internship secara lengkap.</p>
                   </div>
                 </div>
       
                 <div class="faq-item" data-aos="zoom-in" data-aos-delay="200">
                   <div class="faq-header">
                     <h3>Bagaimana cara mendaftar internship?</h3>
                     <i class="bi bi-chevron-down faq-toggle"></i>
                   </div>
                   <div class="faq-content">
                     <p>Silakan klik menu pendaftaran di website ini, lengkapi data yang diminta, unggah surat pengantar dari sekolah/kampus, lalu tunggu proses verifikasi dari tim kami.</p>
                   </div>
                 </div>
       
                 <div class="faq-item">
                   <div class="faq-header">
                     <h3>Berapa lama durasi program internship?</h3>
                     <i class="bi bi-chevron-down faq-toggle"></i>
                   </div>
                   <div class="faq-content">
                     <p>Durasi program disesuaikan dengan ketentuan dari institusi pengirim, umumnya berlangsung antara 1 hingga 6 bulan tergantung program yang diikuti.</p>
                   </div>
                 </div>
       
                 <div class="faq-item">
                   <div class="faq-header">
                     <h3>Apakah peserta mendapatkan sertifikat?</h3>
                     <i class="bi bi-chevron-down faq-toggle"></i>
                   </div>
                   <div class="faq-content">
                     <p>Ya, seluruh peserta yang menyelesaikan program dengan baik akan menerima sertifikat resmi dari PT WIKA sebagai bukti pengalaman internship yang sah.</p>
                   </div>
                 </div>
       
               </div>
             </div>
       
           </div>
         </div>
       </section>

      <!-- /Faq Section -->
      <!-- Testimonials Section -->
      <section id="testimonials" class="testimonials section">
       <!-- Section Title -->
       <div class="container section-title" data-aos="fade-up">
         <h2>Testimoni Alumni Internship</h2>
         <p>Berikut beberapa cerita dan pengalaman dari para alumni yang pernah mengikuti program internship kami.</p>
       </div>
       <!-- End Section Title -->
     
       <div class="container" data-aos="fade-up" data-aos-delay="100">
         <div class="testimonials-slider swiper init-swiper">
           <script type="application/json" class="swiper-config">
             {
               "loop": true,
               "speed": 800,
               "autoplay": {
                 "delay": 5000
               },
               "slidesPerView": 1,
               "spaceBetween": 30,
               "pagination": {
                 "el": ".swiper-pagination",
                 "type": "bullets",
                 "clickable": true
               },
               "breakpoints": {
                 "768": {
                   "slidesPerView": 2
                 },
                 "1200": {
                   "slidesPerView": 3
                 }
               }
             }
           </script>
     
           <div class="swiper-wrapper">
     
             <!-- Testimoni 1 -->
             <div class="swiper-slide">
               <div class="testimonial-card">
                 <div class="testimonial-content">
                   <p><i class="bi bi-quote quote-icon"></i> 
                     Magang di sini sangat berkesan! Aku belajar banyak hal baru yang sebelumnya nggak pernah diajarin di kampus, mulai dari kerja tim, komunikasi profesional, sampai pengelolaan proyek nyata.
                   </p>
                 </div>
                 <div class="testimonial-profile">
                   <div class="rating">
                     <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                   </div>
                   <div class="profile-info">
                     <img src="assets/img/person/person-f-3.webp" alt="Profile Image">
                     <div>
                       <h3>Rani Oktaviani</h3>
                       <h4>Mahasiswa Teknik Informatika</h4>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
     
             <!-- Testimoni 2 -->
             <div class="swiper-slide">
               <div class="testimonial-card">
                 <div class="testimonial-content">
                   <p><i class="bi bi-quote quote-icon"></i>
                     Lingkungan kerjanya asik dan mentor-mentornya sangat suportif. Setiap minggu ada evaluasi yang bikin aku berkembang terus. Terima kasih sudah jadi bagian dari perjalanan karierku!
                   </p>
                 </div>
                 <div class="testimonial-profile">
                   <div class="rating">
                     <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                   </div>
                   <div class="profile-info">
                     <img src="assets/img/person/person-f-10.webp" alt="Profile Image">
                     <div>
                       <h3>Dina Maharani</h3>
                       <h4>UI/UX Designer Intern</h4>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
     
             <!-- Testimoni 3 -->
             <div class="swiper-slide">
               <div class="testimonial-card">
                 <div class="testimonial-content">
                   <p><i class="bi bi-quote quote-icon"></i>
                     Awalnya nervous banget, tapi ternyata suasananya santai dan menyenangkan. Aku bahkan dikasih kesempatan terlibat dalam project penting. Ini pengalaman yang nggak akan aku lupakan!
                   </p>
                 </div>
                 <div class="testimonial-profile">
                   <div class="rating">
                     <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                   </div>
                   <div class="profile-info">
                     <img src="assets/img/person/person-m-5.webp" alt="Profile Image">
                     <div>
                       <h3>Ilham Saputra</h3>
                       <h4>Backend Developer Intern</h4>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
     
             <!-- Testimoni 4 -->
             <div class="swiper-slide">
               <div class="testimonial-card">
                 <div class="testimonial-content">
                   <p><i class="bi bi-quote quote-icon"></i>
                     Aku banyak belajar tentang budaya kerja profesional, dan yang paling penting: aku jadi lebih percaya diri menghadapi dunia kerja setelah lulus nanti.
                   </p>
                 </div>
                 <div class="testimonial-profile">
                   <div class="rating">
                     <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                   </div>
                   <div class="profile-info">
                     <img src="assets/img/person/person-m-2.webp" alt="Profile Image">
                     <div>
                       <h3>Reza Dwi Putra</h3>
                       <h4>Marketing Intern</h4>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
     
             <!-- Testimoni 5 -->
             <div class="swiper-slide">
               <div class="testimonial-card">
                 <div class="testimonial-content">
                   <p><i class="bi bi-quote quote-icon"></i>
                     Selama magang, aku dapet bimbingan yang intens dari supervisor-ku. Semua ilmu dan pengalaman di sini bener-bener jadi bekal buat karierku ke depan.
                   </p>
                 </div>
                 <div class="testimonial-profile">
                   <div class="rating">
                     <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                   </div>
                   <div class="profile-info">
                     <img src="assets/img/person/person-f-7.webp" alt="Profile Image">
                     <div>
                       <h3>Putri Ayuningtyas</h3>
                       <h4>HR Intern</h4>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
     
           </div>
     
           <div class="swiper-pagination"></div>
         </div>
       </div>
     </section>

      <!-- /Testimonials Section -->
      <!-- Contact Section -->
      <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Contact</h2>
        </div>
        <!-- End Section Title -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-wrapper" data-aos="fade-up" data-aos-delay="400">
                <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="name" class="form-control" placeholder="Your name*" required="">
                      </div>
                    </div>
                    <div class="col-md-6 form-group">
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" class="form-control" name="email" placeholder="Email address*" required="">
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-6 form-group">
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="bi bi-phone"></i>
                        </span>
                        <input type="text" class="form-control" name="phone" placeholder="Phone number*" required="">
                      </div>
                    </div>
                    <div class="col-md-6 form-group">
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="bi bi-list"></i>
                        </span>
                        <select name="subject" class="form-control" required="">
                          <option value="">Select service*</option>
                          <option value="Service 1">Consulting</option>
                          <option value="Service 2">Development</option>
                          <option value="Service 3">Marketing</option>
                          <option value="Service 4">Support</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group mt-3">
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="bi bi-chat-dots"></i>
                        </span>
                        <textarea class="form-control" name="message" rows="6" placeholder="Write a message*" required=""></textarea>
                      </div>
                    </div>
                    <div class="my-3">
                      <div class="loading">Loading</div>
                      <div class="error-message"></div>
                      <div class="sent-message">Your message has been sent. Thank you!</div>
                    </div>
                    <div class="text-center">
                      <button type="submit">Submit Message</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /Contact Section -->
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