<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('img/icons/icon-48x48.png')}}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Smartflow</title>

	<link href="{{asset('css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.form.io/formiojs/formio.full.min.css'>
    <script src='https://cdn.form.io/formiojs/formio.full.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="{{asset('js/settings.js')}}"></script>
</head>

<body>
	<div class="wrapper">
		@include('partials.sidebar')
		<div class="main">
			@include('partials.header')

			<main class="content">
                <div class="row col-lg-12 " >
                    <div class="w-100">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3">
                                <div class="card text-bg-primary" style="height: 7rem; background-color:#0d6efd">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title" style="color:#fff">Formulaires</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="file-plus"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mt-1 mb-3" style="color:#fff">{{ $numbers['numberOfFormCreated'] }}</h4>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card" style="height: 7rem; background-color: #198754">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title" style="color:#fff">Modèles</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="check-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mt-1 mb-3" style="color:#fff">{{ $access['numberOfFormCreated'] }}</h4>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
               @yield('content')
			</main>
			@include('partials.footer')
		</div>
	</div>

	<script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/datatables.js')}}"></script>
    <script src="{{asset('js/register.js')}}"></script>
    <script>
		document.addEventListener("DOMContentLoaded", function() {
			// Datatables with Buttons
			var datatablesButtons = $("#datatables-buttons").DataTable({
				responsive: true,
				lengthChange: !1,
				buttons: ["copy", "print"]
			});
			datatablesButtons.buttons().container().appendTo("#datatables-buttons_wrapper .col-md-6:eq(0)");
		});
	</script>
</body>

</html>
