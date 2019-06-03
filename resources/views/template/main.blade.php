<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>DentaCloud | Admin</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
/* 		WebFont.load({
			google: {"families":["Montserrat:100,200,300,400,500,600,700,800,900"]},
			custom: {"families":["Flaticon", "LineAwesome"], urls: ['css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		}); */
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('css/loading.css') }}">		
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/ready.min.css') }}">
    <!-- lightbox -->
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">	
	<!-- CSS bootstrap-datepicker -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker/bootstrap-datepicker3.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker/prettify.css') }}">	

    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.10.18/sc-2.0.0/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.10.18/fc-3.2.5/datatables.min.css"/>     

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">	 
	<link rel="stylesheet" href="{{ asset('css/demo.css') }}">
	<link rel="stylesheet" href="{{ asset('css/customs.css') }}">
<!-- 	<link rel="stylesheet" href="{{ asset('css/app.css') }}" >  -->
</head>
<body>
	<div id="app">
		<div id="loading-wrapper">
			<div id="loading-text">CARGANDO</div>
			<div id="loading-content"></div>
		</div>		
		<router-view></router-view>
	</div>	

	<!--   Core JS Files   -->
	<script src="{{ asset('js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('js/core/popper.min.js') }}"></script>
	<script src="{{ asset('js/core/bootstrap.min.js') }}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
	
	<!-- JQuery imagesLoaded -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.2.0/imagesloaded.pkgd.min.js"></script>	

	<!-- Required to convert named colors to RGB -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.4/rgbcolor.min.js"></script>
	<!-- Optional if you want blur -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/stackblur-canvas/1.4.1/stackblur.min.js"></script>
	<!-- Main canvg code -->
	<script src="https://cdn.jsdelivr.net/npm/canvg/dist/browser/canvg.min.js"></script>
	
	<!-- Moment JS -->
	<script src="{{ asset('js/plugin/moment/moment.min.js') }}"></script>
	<script src="{{ asset('js/plugin/moment/moment-with-locales.min.js') }}"></script>	

	<!-- Chart JS -->
	<script src="{{ asset('js/plugin/chart.js/chart.min.js') }}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('js/plugin/chart-circle/circles.min.js') }}"></script>

	<!-- Datatables -->
	<script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- Bootstrap Toggle -->
	<script src="{{ asset('js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
	<script src="{{ asset('js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

	<!-- Google Maps Plugin -->
	<script src="{{ asset('js/plugin/gmaps/gmaps.js') }}"></script>

	<!-- Dropzone -->
	<script src="{{ asset('js/plugin/dropzone/dropzone.min.js') }}"></script>

	<!-- Fullcalendar -->
	<script src="{{ asset('js/plugin/fullcalendar/fullcalendar.min.js') }}"></script>	
	<script src="{{ asset('js/plugin/fullcalendar/locale-all.js') }}"></script>		

	<!-- DateTimePicker -->
	<script src="{{ asset('js/plugin/datepicker/bootstrap-datetimepicker.min.js') }}"></script>
	
	<!-- Bootstrap datepicker -->
    <script src="{{ asset('js/plugin/bootstrap-datepicker/js/prettify.min.js') }}"></script>
    <script src="{{ asset('js/plugin/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>	
	<script src="{{ asset('js/plugin/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}" charset="UTF-8"></script>	

	<!-- Bootstrap Tagsinput -->
	<script src="{{ asset('js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

	<!-- Bootstrap Wizard -->
	<script src="{{ asset('js/plugin/bootstrap-wizard/bootstrapwizard.js') }}"></script>

	<!-- jQuery Validation -->
	<script src="{{ asset('js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>

	<!-- Summernote -->
	<script src="{{ asset('js/plugin/summernote/summernote-bs4.min.js') }}"></script>

	<!-- Select2 -->
	<script src="{{ asset('js/plugin/select2/select2.full.min.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Lightbox Scripts -->
    <script src="{{ asset('js/plugin/lightbox2/lightbox.js') }}"></script>  
	<!-- Ready Pro JS -->
	<script src="{{ asset('js/ready.min.js') }}"></script>

	<!-- Ready Pro DEMO methods, don't include it in your project! -->
	<script src="{{ asset('js/setting-demo.js') }}"></script>
	<script src="{{ asset('js/demo.js') }}"></script>
    <!-- Files VUE.JS 2-->
    <script src="{{ asset('js/app.js') }}"></script>  	
</body>
</html>