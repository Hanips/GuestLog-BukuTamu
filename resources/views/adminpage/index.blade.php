<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title> @yield('title_page') | SIBPro</title>
  <link
  href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAADdZgUA/vz7AO+6kADcZAAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMzMzMzMzMzMzMzMzMzMzMzMzMzREQ0QzMzMzRERERDMzMzREMzREMzMzNEMzNEQzMzM0QzMzRDMzMzREMzREMzMzNERAREQzMzMzRERERDMzMzM0RBJEMzMzMzMzMkQzMzMzMzMyRDMzMzMzMzJEMzMzMzMzMzMzMzMzMzMzMzMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"
  rel="icon" type="image/x-icon">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('adminpage/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminpage/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('adminpage/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminpage/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('adminpage/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminpage/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminpage/modules/notiflix/src/notiflix.css') }}">
  {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet"> --}}

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('adminpage/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('adminpage/css/components.css') }}">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">

      @if (Auth::user()->role != 'Pengguna' && !(Auth::user()->role == 'Satpam' && (Request::is('admin/officer/create') || Request::is('admin/officer/*/edit'))))
        <!-- ======= Header ======= -->
        @include('adminpage.header')

        <!-- ======= Sidebar ======= -->      
        @include('adminpage.sidebar')
      

        <!-- ======= Main Content ======= -->
        @yield('content')

        <footer class="main-footer">
          <div class="footer-left">
            SMK BP Darul Ulum Rejosari, Grobogan
          </div>
          <div class="footer-right">
            
          </div>
        </footer>
      @endif
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('adminpage/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/popper.js') }}"></script>
  <script src="{{ asset('adminpage/modules/tooltip.js') }}"></script>
  <script src="{{ asset('adminpage/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/moment.min.js') }}"></script>
  <script src="{{ asset('adminpage/js/stisla.js') }}"></script>
  
  <!-- JS Libraies -->
  <script src="{{ asset('adminpage/modules/jquery.sparkline.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/chart.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ asset('adminpage/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/notiflix/src/notiflix.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('adminpage/js/page/index.js') }}"></script>
  
  <!-- Template JS File -->
  <script src="{{ asset('adminpage/js/scripts.js') }}"></script>
  <script src="{{ asset('adminpage/js/custom.js') }}"></script>

  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
  <script>
      $(document).ready(function(){
          $("[name='status']").bootstrapSwitch();
      });
  </script> --}}
</body>
</html>