<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Internship</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ 'templates/assets/vendor/fonts/boxicons.css' }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ 'templates/assets/vendor/css/core.css' }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ 'templates/assets/vendor/css/theme-default.cssa' }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ 'templates/assets/css/demo.css' }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ 'templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css' }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ 'templates/assets/vendor/css/pages/page-auth.css' }}" />

    <!-- Helpers -->
    <script src="{{ 'templates/assets/vendor/js/helpers.js' }}"></script>
    
    <script src="{{ 'templates/assets/js/config.js' }}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          @yield('container')
        </div>
      </div>
    </div>

    <!-- / Content -->

{{-- ====================================================================================== --}}


<script src="{{'templates/assets/vendor/libs/jquery/jquery.js'}}"></script>
<script src="{{'templates/assets/vendor/libs/popper/popper.js'}}"></script>
<script src="{{'templates/assets/vendor/js/bootstrap.js'}}"></script>
<script src="{{'templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'}}"></script>
<script src="{{'templates/assets/vendor/js/menu.js'}}"></script>


<!-- Main JS -->
<script src="{{'templates/assets/js/main.js'}}"></script>

<!-- Page JS -->

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
