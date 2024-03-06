<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Testing PT Hanatekindo</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('') }}assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('logo.jpg') }}" />
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('') }}assets/css/sweetalert2.min.css">
  <script src="{{ asset('') }}assets/js/sweetalert2.min.js"></script>

    @yield('style')
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:{{ asset('') }}partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="{{ url('') }}"><img src="{{ asset('logo.jpg') }}" alt="logo" style="height: 100px;" /></a>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:{{ asset('') }}partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ url('users') }}">
                <span class="menu-title">Master Pengguna</span>
                <i class="mdi mdi-face menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="logout" href="#">
                <span class="menu-title">Logout</span>
                <i class="mdi mdi-logout menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
              @yield('content')
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:{{ asset('') }}partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
              <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('') }}assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('') }}assets/js/off-canvas.js"></script>
    <script src="{{ asset('') }}assets/js/hoverable-collapse.js"></script>
    <script src="{{ asset('') }}assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    @yield('scripts')
    <script type="text/javascript">
      $(function(){
        
          let token = window.localStorage.getItem("token");
          if(!token){
            window.location.href = "/login";
          }
          $("#logout").on("click",function(){
            $.ajax({
                url: "{{ url('api/logout') }}",
                method: 'GET',  
                headers:{'Authorization':'bearer ' + window.localStorage.getItem("token")},
                success: function(response) {
                  localStorage.removeItem("token");
                  window.location.href = "/login";
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  console.log(errorThrown);
                  localStorage.removeItem("token");
                }
            });
          })
        })
      
    </script>
  </body>
</html>