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
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title>Connexion | Smartflow</title>

	<link href="{{asset('css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-4 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="card" style="border-radius: 0.35rem;">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">
										<h3 style="font-weight: 800">Connexion | Smartflow</h3>
									</div>
									<form method="POST" action="{{ route('auth.handle.login') }}">
                                        @csrf
                                        @if (Session::get('bad_credentials'))
                                        <div class="d-flex justify-content-center mb-1 mt-2">

                                        <div class="alert alert-danger alert-outline-coloured alert-dismissible" role="alert">
											<button type="button" class="btn-close" style="height: 0.05rem; width: 0.05rem;" data-bs-dismiss="alert" aria-label="Close"></button>
											<div class="alert-icon">
												<i class="far fa-fw fa-bell"></i>
											</div>
											<div class="alert-message">
												<b style="font-size: 11px; color: red;">{{ Session::get('bad_credentials') }}</b>
											</div>
										</div>
                                        </div>
                                        @endif
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="username" placeholder="Entrez votre email" />
										</div>
										<div class="mb-2">
											<label class="form-label">Mot de passe</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Entrer votre mot de passe" />
										</div>
                                        <small>
                                            <a class="mt-1 " href="{{route('auth.reset')}}"> Mot de passe oublié?</a>
                                          </small>
										<div>
											<label class="form-check mt-2">
            <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
            <span class="form-check-label">
              Se souvenir de moi
            </span>
          </label>
										</div>
										<div class="text-center mt-3">
											<button type="submit" class="btn btn-lg btn-primary">Connexion</button>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{asset('js/app.js')}}"></script>

</body>

</html>
