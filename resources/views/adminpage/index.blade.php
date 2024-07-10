<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> @yield('title_page') | GuestLog</title>
    <link rel="icon" href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAADdZgUA/vz7AO+6kADcZAAA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMzMzMzMzMzMzMzMzMzMzMzMzMzREQ0QzMzMzRERERDMzMzREMzREMzMzNEMzNEQzMzM0QzMzRDMzMzREMzREMzMzNERAREQzMzMzRERERDMzMzM0RBJEMzMzMzMzMkQzMzMzMzMyRDMzMzMzMzJEMzMzMzMzMzMzMzMzMzMzMzMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('adminpage/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/modules/notiflix/src/notiflix.css') }}">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

    @stack('styles')
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            @if (Auth::user()->role != 'Pengguna')
                <!-- ======= Header ======= -->
                @include('adminpage.header')

                <!-- ======= Sidebar ======= -->      
                @include('adminpage.sidebar')

                <!-- ======= Main Content ======= -->
                @yield('content')

                <footer class="main-footer">
                    <div class="footer-left">
                        GuestLog | SMK BP Darul Ulum Rejosari, Grobogan
                    </div>
                    <div class="footer-right">

                    </div>
                </footer>
            @endif
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('adminpage/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('adminpage/js/scripts.js') }}"></script>
    <script src="{{ asset('adminpage/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('adminpage/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>

    <form action="{{ url('/logout') }}" method="post" id="log-out-form">
        @csrf
    </form>

    <script>
        var form = document.getElementById("log-out-form");
        document.getElementById("logOutFunction").addEventListener("click", function() {
            form.submit();
        });
    </script>

    <script src="{{ asset('adminpage/modules/tooltip.js') }}"></script>
    <script src="{{ asset('adminpage/modules/popper.js') }}"></script>
    <script src="{{ asset('adminpage/modules/notiflix/src/notiflix.js') }}"></script>
    <script src="{{ asset('adminpage/modules/moment.min.js') }}"></script>
    <script src="{{ asset('adminpage/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('adminpage/js/stisla.js') }}"></script>
    <script src="{{ asset('adminpage/js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
