<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ __('Access Denied') }} | SIBPro</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('adminpage/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminpage/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->

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
  <!-- /END GA -->
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            <h1>403</h1>
            <div class="page-description">
              {{ __('You do not have access to this page.') }}
            </div>
            <div class="page-search">
              <form>
                <div class="form-group floating-addon floating-addon-not-append">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="simple-footer mt-5">
          SMK BP Darul Ulum Rejosari, Grobogan
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('adminpage/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/popper.js') }}"></script>
  <script src="{{ asset('adminpage/modules/tooltip.js') }}"></script>
  <script src="{{ asset('adminpage/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('adminpage/modules/moment.min.js') }}"></script>
  <script src="{{ asset('adminpage/js/stisla.js') }}"></script>

  <!-- JS Libraries -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{ asset('adminpage/js/scripts.js') }}"></script>
  <script src="{{ asset('adminpage/js/custom.js') }}"></script>
</body>
</html>
