<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>CRUD DATA | @yield('title')</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin.min.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">

	<link rel="shortcut icon" type="text/css" href="{{ asset('assets/images/logo.png') }}">

	<script type="text/javascript" src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
	
</head>
<body style="background-color: #BFCDEC">
	<div class="bg-primary-1 py-2 position-fixed w-100" style="z-index: 100">
		<div class="mx-md-5 mx-4">
			<div class="d-flex align-items-center">
				<div class="col-6 d-flex align-items-center">
					<a href="javascript:;" onclick="openSidebar()"><i class="fas fa-bars text-white me-3 d-lg-none"></i></a>
					<h5 class="my-0 text-white text-sm-14">CRUD DATA</h5>
				</div>
				<div class="col-6 text-end">
					<div class="d-flex align-items-center justify-content-end">
						<a href="javascript:;" onclick="logout()"><img class="logout" src="{{ asset('assets/images/admin/keluar.png') }}"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="">
		<div id="sidebar" class="sidebar close position-fixed bg-white ps-md-5 px-3">
			<h5><strong>Selamat datang</strong></h5>
			<h5 class="text-secondary-2 nama"></h5>
			<br>
			<div class="menu">
				<span class="text-secondary-2">Menu</span>
				<br>
				<a href="{{ route('crud.dashboard') }}" class="side-menu text-decoration-none d-flex align-items-center text-dark mt-2">
					<img src="{{ asset('assets/images/admin/dashboard.png') }}" class="me-3 my-2"> Dashboard
				</a>
				<a href="{{ route('crud.profil') }}" class="side-menu text-decoration-none d-flex align-items-center text-dark">
					<img src="{{ asset('assets/images/admin/apartment.png') }}" class="me-3 my-2"> Profil
				</a>
			</div>
			<br>
			<br><br>
		</div>
		<div class="content">
			@yield('content')
		</div>
	</div>
	<script type="text/javascript">
		var id = document.cookie.split(';')[0].split('=')[1];
		fetch("http://localhost:8000/api/v1/users/show/"+id, {
			method: "GET",
		})
		.then((response) => response.json())
		.then((data) => {
			$(".nama").html(data.data.name)
		})
		.catch(function(error) {
		alert("Terjadi kesalahan. Silakan coba lagi.");
		});
		function logout(){
			alert('berhasil logout')
			document.cookie = "id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			window.location.href = `{{ route('auth.login') }}`;
		}
	</script>
</body>
</html>