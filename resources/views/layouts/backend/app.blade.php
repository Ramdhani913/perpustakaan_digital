<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Gaia Library - Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href={{asset("assets/vendors/typicons/typicons.css")}}>
  <link rel="stylesheet" href={{asset("assets/vendors/css/vendor.bundle.base.css")}}>
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href={{asset("assets/css/vertical-layout-light/style.css")}}>
  <!-- endinject -->
  <link rel="shortcut icon" href={{asset("assets/images/favicon.png")}} />
</head>
<body>
  {{-- <div class="row" id="proBanner">
    <div class="col-12">
      <span class="d-flex align-items-center purchase-popup">
        <p>Get tons of UI components, Plugins, multiple layouts, 20+ sample pages, and more!</p>
        <a href="https://bootstrapdash.com/demo/polluxui/template/index.html?utm_source=organic&utm_medium=banner&utm_campaign=free-preview" target="_blank" class="btn download-button purchase-button ml-auto">Upgrade To Pro</a>
        <i class="typcn typcn-delete-outline" id="bannerClose"></i>
      </span>
    </div>
  </div> --}}
  <div class="container-scroller">

    @include('layouts.backend.navbar')
   
    <div class="container-fluid page-body-wrapper">
    
    @include('layouts.backend.sidebar')

    
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
              @yield('content')
            @include('layouts.backend.footer')
        </div>

      
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src={{asset("assets/vendors/js/vendor.bundle.base.js")}}></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src={{asset("assets/vendors/chart.js/Chart.min.js")}}></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src={{asset("assets/js/off-canvas.js")}}></script>
  <script src={{asset("assets/js/hoverable-collapse.js")}}></script>
  <script src={{asset("assets/js/template.js")}}></script>
  <script src={{asset("assets/js/settings.js")}}></script>
  <script src={{asset("assets/js/todolist.js")}}></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src={{asset("assets/js/dashboard.js")}}></script>
  <!-- End custom js for this page-->
</body>

</html>

