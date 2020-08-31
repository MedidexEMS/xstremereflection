<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('page-title') - {{ setting('app_name') }}</title>
    <!-- plugins:css -->
    <script src="https://kit.fontawesome.com/6c1803817f.js" crossorigin="anonymous" `SameSite=None`></script>
    <link href="/assets/css/opp.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/corona/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/corona/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/corona/css/modern-vertical/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/corona/images/favicon.png" />
    <link href="/assets/css/theme/blue.min.css" id="theme" rel="stylesheet" />


    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>



    <style>
        .kbw-signature { width: 100%; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>
    @yield('styles')

    @hook('app:styles')

    <script src="https://cdn.tiny.cloud/1/vhwdr00g7rh6pkyyon9gh805fujprojdb75iywpnv6akkt2e/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


</head>
<body >
<div class="container-scroller">



        <div class="main-panel">
            <div class="content-wrapper ">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@yield('modals')

<script src="/assets/corona/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="/assets/vendors/chart.js/Chart.min.js"></script>
<script src="/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->


<!-- endinject -->
<!-- Custom js for this page -->
<script src="/assets/corona/js/dashboard.js"></script>



<script>
    $('.toast').toast('show')
</script>



@yield('scripts')

@hook('app:scripts')
</body>

</html>
