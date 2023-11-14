<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com/">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<title>Mot de passe oublié? | Smartflow</title>

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
	<link href="{{asset('css/app.css')}}" rel="stylesheet">
	<script src="{{asset('js/settings.js')}}"></script>
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
	<main class="d-flex w-100 h-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Mot de passe oublié?</h1>
							<p class="lead">
								Entrer votre email pour modifier votre mot de passe.
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="POST" action="{{ route('auth.handle.reset') }}" >
                                        @csrf
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Entrez votre email" />
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class='btn btn-lg btn-primary'>Modifier</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Vous n'avez pas de compte? <a href="{{route('auth.register')}}">Créez un compte!</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="js/app.js"></script>


</body>

</html>
