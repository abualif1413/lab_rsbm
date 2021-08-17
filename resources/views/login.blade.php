

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Lab RSBM</title>
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

		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet"> 
		<style type="text/css">
			body {
				font-family: 'Roboto', sans-serif;
				font-size: 90%;
			}

			table.table-hover tr {
				transition: 0.05s background-color, 0.05s color;
			}

			table.table-hover tr:hover {
				background-color: rgba(49, 152, 255, 0.76);
				color: white;
				transition-delay:0.05s;
			}
		</style>
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="#"><b>Pelayanan Laboratorium</b></a>
			</div>
			<!-- /.login-logo -->
			<div class="card">
				<div class="card-body login-card-body">
					<p class="login-box-msg">Silahkan Login Untuk Memulai</p>
					<form action="{{ url('/login/attempt') }}" method="post">
						@csrf()
						<div class="input-group mb-3">
							<input type="email" name="email" class="form-control" placeholder="Email">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-envelope"></span>
								</div>
							</div>
						</div>
						<div class="input-group mb-3">
							<input type="password" name="password" class="form-control" placeholder="Password">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-8">
								<div class="icheck-primary">
									<input type="checkbox" id="remember">
									<label for="remember">
									Remember Me
									</label>
								</div>
							</div>
							<!-- /.col -->
							<div class="col-4">
								<button type="submit" class="btn btn-primary btn-block">Sign In</button>
							</div>
							<!-- /.col -->
						</div>
					</form>
				</div>
				<!-- /.login-card-body -->
			</div>
		</div>
		<!-- /.login-box -->
		<!-- jQuery -->
		<script src="{{url("admin-tpl/plugins/jquery/jquery.min.js")}}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{url("admin-tpl/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
		<!-- AdminLTE App -->
		<script src="{{url("admin-tpl/dist/js/adminlte.min.js")}}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{url("admin-tpl/dist/js/demo.js")}}"></script>
	</body>
</html>