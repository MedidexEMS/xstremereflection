<!DOCTYPE html>
<html>


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('page-title') - {{ setting('app_name') }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!-- Favicon icon -->
    <link rel="icon" href="/assets/indexial/img/favicon.png" type="image/x-icon"/>
    <!-- Fonts and icons -->
    <script src="/assets/indexial/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Work Sans:300,400,500,600,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['/assets/indexial/css/fonts.min.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/indexial/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/indexial/css/indexial.css">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="/assets/indexial/css/demo.css">
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <!-- plugins:css -->
    <script src="https://kit.fontawesome.com/6c1803817f.js" crossorigin="anonymous" `SameSite=None`></script>


</head>
<body >
<div class="wrapper">
    @include('partials.mainHeader')
    @include('partials.sideBar')
    <div class="main-panel">
        <div class="container">
            @include('partials.actionHeader')

            <div class="page-inner mt--5">
                @yield('content')
            </div>

            @include('partials.footer')
        </div>
    </div>

</div>

@yield('modals')
@include('invoice.partials.customerModal')

<!--   Core JS Files   -->
<script src="/assets/indexial/js/core/jquery.3.2.1.min.js"></script>
<script src="/assets/indexial/js/core/popper.min.js"></script>
<script src="/assets/indexial/js/core/bootstrap.min.js"></script>

<!-- jQuery UI -->
<script src="/assets/indexial/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="/assets/indexial/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="/assets/indexial/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Moment JS -->
<script src="/assets/indexial/js/plugin/moment/moment.min.js"></script>

<!-- Chart JS -->
<script src="/assets/indexial/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="/assets/indexial/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="/assets/indexial/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="/assets/indexial/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="/assets/indexial/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- Bootstrap Toggle -->
<script src="/assets/indexial/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="/assets/indexial/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script src="/assets/indexial/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

<!-- Google Maps Plugin -->
<script src="/assets/indexial/js/plugin/gmaps/gmaps.js"></script>

<!-- Dropzone -->
<script src="/assets/indexial/js/plugin/dropzone/dropzone.min.js"></script>

<!-- Fullcalendar -->
<script src="/assets/indexial/js/plugin/fullcalendar/fullcalendar.min.js"></script>

<!-- DateTimePicker -->
<script src="/assets/indexial/js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>

<!-- Bootstrap Tagsinput -->
<script src="/assets/indexial/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

<!-- Bootstrap Wizard -->
<script src="/assets/indexial/js/plugin/bootstrap-wizard/bootstrapwizard.js"></script>

<!-- jQuery Validation -->
<script src="/assets/indexial/js/plugin/jquery.validate/jquery.validate.min.js"></script>

<!-- Summernote -->
<script src="/assets/indexial/js/plugin/summernote/summernote-bs4.min.js"></script>

<!-- Select2 -->
<script src="/assets/indexial/js/plugin/select2/select2.full.min.js"></script>

<!-- Sweet Alert -->
<script src="/assets/indexial/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Owl Carousel -->
<script src="/assets/indexial/js/plugin/owl-carousel/owl.carousel.min.js"></script>

<!-- Magnific Popup -->
<script src="/assets/indexial/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js"></script>

<!-- Indexial JS -->
<script src="/assets/indexial/js/indexial.min.js"></script>

<script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<!-- Indexial DEMO methods, don't include it in your project! -->
<script src="/assets/indexial/js/setting-demo.js"></script>
<script src="/assets/indexial/js/demo.js"></script>


<script>

    $('#customerModal').on('shown.bs.modal', function (){

        $('#datepicker-popup').datepicker({
            todayHighlight: true,
        });

        $('#customerInvoiceForm').load('/customer/form', function () {
            $( "#newCustomer" ).hide();
        });
    });

    function customerChange() {
        var customer = document.getElementById("customer").value;

        if(customer == 0){
            console.log('New Customer')
            $( "#newCustomer" ).show();
        }
        else {
            console.log('Existing Customer')
            $( "#newCustomer" ).hide();
        }
    }

</script>

<script>
    $('.toast').toast('show')
</script>

@yield('scripts')

@hook('app:scripts')
</body>

</html>
