<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ config('app.name') }}</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="{!! asset('plugins/fontawesome-free/css/all.min.css') !!}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{!! asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') !!}">
<!-- Theme style -->
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<!-- icheck bootstrap -->
<link rel="stylesheet" href="{!! asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
<!-- DataTables -->
<link rel="stylesheet" href="{!! asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
<!-- fullCalendar -->
<link rel="stylesheet" href="{!! asset('plugins/fullcalendar/main.css') !!}">
<!-- daterange picker -->
<link rel="stylesheet" href="{!! asset('plugins/daterangepicker/daterangepicker.css') !!}">
<!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{!! asset('plugins/ekko-lightbox/ekko-lightbox.css') !!}">
<!-- Select2 -->
<link rel="stylesheet" href="{!! asset('plugins/select2/css/select2.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') !!}">
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="{!! asset('plugins/select2/css/select2.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') !!}">

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
<link href="{{ asset('css/cropper.css') }}" rel="stylesheet">

<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('/upload/logo.png') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">
@yield('third_party_stylesheets')

@stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper">


@include('layouts.header')

<!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    @yield('content')
  </section>
</div>


</div>


@yield('third_party_scripts')
<!-- Bootstrap -->
<script src="{!! asset('plugins/jquery/jquery.min.js') !!}"></script>
<!-- Bootstrap -->
<script src="{!! asset('plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
<!-- overlayScrollbars -->
<script src="{!! asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('dist/js/adminlte.js') !!}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{!! asset('plugins/jquery-mousewheel/jquery.mousewheel.js') !!}"></script>
<script src="{!! asset('plugins/raphael/raphael.min.js') !!}"></script>
<script src="{!! asset('plugins/jquery-mapael/jquery.mapael.min.js') !!}"></script>
<script src="{!! asset('plugins/jquery-mapael/maps/usa_states.min.js') !!}"></script>
<!-- ChartJS -->
<script src="{!! asset('plugins/chart.js/Chart.min.js') !!}"></script>
<script src="{!! asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="{!! asset('plugins/datatables/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('plugins/jszip/jszip.min.js') !!}"></script>
<script src="{!! asset('plugins/pdfmake/pdfmake.min.js') !!}"></script>
<script src="{!! asset('plugins/pdfmake/vfs_fonts.js') !!}"></script>
<script src="{!! asset('plugins/datatables-buttons/js/buttons.html5.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables-buttons/js/buttons.print.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables-buttons/js/buttons.colVis.min.js') !!}"></script>
<script src="{!! asset('plugins/moment/moment.min.js') !!}"></script>
<script src="{!! asset('plugins/inputmask/jquery.inputmask.min.js') !!}"></script>
<script src="{!! asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<!-- fullCalendar 2.2.5 -->
<script src="{!! asset('plugins/moment/moment.min.js') !!}"></script>
<script src="{!! asset('plugins/fullcalendar/main.js') !!}"></script>
<script src="{!! asset('plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
<!-- date-range-picker -->
<script src="{!! asset('plugins/daterangepicker/daterangepicker.js') !!}"></script>
<!-- Ekko Lightbox -->
<script src="{!! asset('plugins/ekko-lightbox/ekko-lightbox.min.js') !!}"></script>
<!-- Select2 -->
<script src="{!! asset('plugins/select2/js/select2.full.min.js') !!}"></script>
<script src="{{ asset('js/dropzone.js') }}" ></script>
<script src="{{ asset('js/cropper.js') }}" ></script>




@stack('page_scripts')
<script>
$(function () {

  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    //"responsive": true,
  });

  $('#example3').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    //"responsive": true,
  });

  $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert-success").slideUp(500);
  });
});

$(".text").keypress(function(event){
        var inputValue = event.which;
        // allow letters and whitespaces only.
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) { 
            event.preventDefault(); 
        }
    });

$('.number').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
    event.preventDefault();
  }
});

$('.select2').select2({
  theme: 'bootstrap4'
});

$("input[data-bootstrap-switch]").each(function(){
$(this).bootstrapSwitch('state', $(this).prop('checked'));
})
$("#submit_button").click(function() {
  $('#loading').show();
});
$('#loading').hide();

		function duplicateemail(id){
		var email = $("#email").val().trim();
		var _token = $('input[name="_token"]').val();
		$.ajax({
			type: "post",
			url: '{{ url('checkemail') }}',
			data:{id:id,email:email,_token:_token},
			
			success: function(res) {
				if(res.exists){
					$("#save").prop('disabled', true);
					$("#dupemail").html("Duplicate Email");
				}else{
					$("#save").prop('disabled', false);
					$("#dupemail").html("");
				}
			},
			
			error: function (jqXHR, exception) {
				console.log(exception);
			}
		});
		}

        function duplicateaadhar(id){
        var aadhar = $("#aadhar").val().trim();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "post",
            url: '{{ url('checkaadhar') }}',
            data:{id:id,aadhar:aadhar,_token:_token},
            
            success: function(res) {
                if(res.exists){
                    $("#save").prop('disabled', true);
                    $("#dupaadhar").html("Duplicate Aadhar Number");
                }else{
                    $("#save").prop('disabled', false);
                    $("#dupaadhar").html("");
                }
            },
            
            error: function (jqXHR, exception) {
                console.log(exception);
            }
        });
        }

</script>
</body>
</html>
