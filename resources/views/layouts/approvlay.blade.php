<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('img/icons/icon-48x48.png')}}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Smartflow</title>

	<link href="{{asset('css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    <link rel='stylesheet' href='https://cdn.form.io/formiojs/formio.full.min.css'>
    <script src='https://cdn.form.io/formiojs/formio.full.min.js'></script>

    <!-- Utilisez jQuery avant Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Utilisez Bootstrap Bundle (JavaScript de Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></script>

</head>

<body>
	<div class="wrapper">
		@include('partials.sidebar')
		<div class="main">
			@include('partials.header')

			<main class="content">
                <div class="row col-lg-12" >
                    <div class="w-100">
                        <div class="row d-flex justify-content-center ml-4">

                                <div class="col-md-3">
                                <div class="card" style="height: 7rem; background-color: #1d6f75">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title" style="color:#fff">En attente</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="loader"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mt-1 mb-3" style="color:#fff">{{ $numbers['initiatedNumber'] }}</h4>
                                    </div>
                                </div>
                        </div>

                            <div class="col-md-3">
                                <div class="card" style="height: 7rem; background-color: #198754">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title" style="color:#fff">Validés</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="check-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mt-1 mb-3" style="color:#fff">{{ $numbers['validatedNumber'] }}</h4>

                                    </div>
                                </div>
                            </div>
                                <div class="col-md-3">
                                <div class="card" style="height: 7rem; background-color: #dc3545">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title" style="color:#fff">Rejetés</h5>
                                            </div>

                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="x-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mt-1 mb-3" style="color:#fff">{{ $numbers['rejectedNumber'] }}</h4>
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
    <script src="https://unpkg.com/signature_pad@4.1.6/dist/signature_pad.umd.js">
    <script>
    const canvas = document.querySelector("canvas");
    const signaturePad = new SignaturePad(canvas);
  </script>
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
