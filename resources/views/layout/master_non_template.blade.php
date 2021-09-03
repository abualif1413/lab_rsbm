<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Lab. RSBM</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{url("admin-tpl/plugins/fontawesome-free/css/all.min.css")}}">
		<!-- DataTables -->
		<link rel="stylesheet" href="{{url("admin-tpl/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
		<link rel="stylesheet" href="{{url("admin-tpl/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
		<link rel="stylesheet" href="{{url("admin-tpl/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
		<!-- overlayScrollbars -->
		<link rel="stylesheet" href="{{url("admin-tpl/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{url("admin-tpl/dist/css/adminlte.min.css")}}">
		<!-- Select2 -->
		<link rel="stylesheet" href="{{url("admin-tpl/plugins/select2/css/select2.min.css")}}">
		<link rel="stylesheet" href="{{url("admin-tpl/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
		<!-- jstree -->
		<link rel="stylesheet" href="{{url("js/jstree/dist/themes/default/style.min.css")}}">

		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet"> 
		<style type="text/css">
			body {
				font-family: 'Roboto', sans-serif;
				font-size: 90%;
				font-family: 'Roboto', sans-serif;
				font-size: 90%;
				background-repeat: no-repeat;
				background-position: top right;
				background-size: 300px;
				background-color: #063c6a !important;
				background-attachment: fixed;
				color: white;
			}

			table.table-hover tr {
				transition: 0.05s background-color, 0.05s color;
			}

			table.table-hover tr:hover {
				background-color: rgba(250, 244, 158, 0.76);
				transition-delay:0.05s;
			}

			@media screen and (min-width: 768px) {
				body {
					font-family: 'Roboto', sans-serif;
					font-size: 90%;
					font-family: 'Roboto', sans-serif;
					font-size: 90%;
					background-image: url('{{ url("/public/images/macho.jpg") }}');
					background-repeat: no-repeat;
					background-position: top right;
					background-size: 300px;
					background-color: #063c6a !important;
					background-attachment: fixed;
					color: white;
				}

				table.table-hover tr {
					transition: 0.05s background-color, 0.05s color;
				}

				table.table-hover tr:hover {
					background-color: rgba(250, 244, 158, 0.76);
					transition-delay:0.05s;
				}
			}
			
		</style>
	</head>
	<body>
		<div class="container">
            @yield('content')
        </div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{url("admin-tpl/plugins/jquery/jquery.min.js")}}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{url("admin-tpl/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
		<!-- Select2 -->
		<script src="{{url("admin-tpl/plugins/select2/js/select2.full.min.js")}}"></script>
		<!-- overlayScrollbars -->
		<script src="{{url("admin-tpl/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
		<!-- DataTables  & Plugins -->
		<script src="{{url("admin-tpl/plugins/datatables/jquery.dataTables.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/datatables-buttons/js/dataTables.buttons.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/jszip/jszip.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/pdfmake/pdfmake.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/pdfmake/vfs_fonts.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/datatables-buttons/js/buttons.html5.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/datatables-buttons/js/buttons.print.min.js")}}"></script>
		<script src="{{url("admin-tpl/plugins/datatables-buttons/js/buttons.colVis.min.js")}}"></script>
		<!-- AdminLTE App -->
		<script src="{{url("admin-tpl/dist/js/adminlte.min.js")}}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{url("admin-tpl/dist/js/demo.js")}}"></script>
		<!-- jstree -->
		<script src="{{url("js/jstree/dist/jstree.min.js")}}"></script>

		<script type="text/javascript">
			$(function() {
				//Initialize Select2 Elements
				$('.select2').select2()

				//Initialize Select2 Elements
				$('.select2bs4').select2({
					theme: 'bootstrap4'
				})
			})
		</script>
		@yield('js')
		@yield('modal')
	</body>
</html>