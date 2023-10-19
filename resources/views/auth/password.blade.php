<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demo.adminkit.io/pages-reset-password by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Aug 2023 14:34:12 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="pages-reset-password-2.html" />

    <title>Mot de passe oublié? | Smartflow</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <!-- <link href="css/light.css" rel="stylesheet"> -->
    <!-- <link href="css/dark.css" rel="stylesheet"> -->

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/settings.js') }}"></script>
    <style>
        body {
            opacity: 0;
        }
    </style>
    <!-- END SETTINGS -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120946860-10"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-120946860-10', {
            'anonymize_ip': true
        });
    </script>
</head>
<!--
  HOW TO USE:
  data-theme: default (default), dark, light, colored
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-layout: default (default), compact
-->






<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <main class="d-flex w-100 h-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        @if (session()->has('error'))
                            <div class="d-flex justify-content-center mb-1 mt-2">
                                <div class="col-md-7">
                                    <div class="alert alert-danger alert-outline-coloured alert-dismissible"
                                        role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <div class="alert-icon">
                                            <i class="far fa-fw fa-bell"></i>
                                        </div>
                                        <div class="alert-message">
                                            <b style="font-size: 11px; color: red;">{{ Session::get('error') }}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="text-center mt-4">
                            <h1 class="h2">Réinitialisation du mot de passe</h1>

                        </div>
                        @if (isset($error))
                            <div id="error-message" style="background-color:red;color:white"
                                class="bg-red-200 border border-red-600 text-red-900 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Erreur : </strong>
                                <span class="block sm:inline">{{ $error }}</span>
                            </div>

                            <script>
                                setTimeout(function() {
                                    document.getElementById('error-message').style.display = 'none';
                                }, 5000); // 5000 ms = 5 sec
                            </script>
                        @endif

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <form method="POST" action="{{ route('auth.handle.password') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Nouveau mot de passe</label>
                                            <input class="form-control form-control-lg" type="password" id="password"
                                                name="password" placeholder="Entrez le nouveau mot de passe" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirmation du mot de passe</label>
                                            <input class="form-control form-control-lg" id="confirm" type="password"
                                                name="confirm" placeholder="Confirmez votre mot de passe" />
                                            <input id="personId" type="hidden" name="personId"
                                                value={{ $personId }} />
                                        </div>
                                        <div class="mb-3" id="error-message" style="color: red;"></div>

                                        <div class="d-grid gap-2 mt-3">
                                            <button type="submit" class='btn btn-lg btn-primary'
                                                id="submitButton">Enregistrer</button>
                                        </div> <br>

                                        <style>
                                            .validator-criters {
                                                list-style: none;
                                                background-color: rgba(0, 0, 0, 0.05);
                                                padding: 0;
                                            }

                                            .validator-criters li {
                                                margin-bottom: 10px;
                                                padding: 0px;
                                                font-size: 12px;
                                                /*border: 1px solid #ddd;
                /* background-color: rgba(0, 0, 0, 0.05); */
                                                border-radius: 5px;
                                            }

                                            .validator-criters i {
                                                margin-right: 10px;
                                            }
                                        </style>

                                        <ul class="validator-criters mb-1">
                                            <li class="condition chiffre"><i class="far fa-check-circle"></i>Votre mot
                                                de passe doit comporter au minimum 1 chiffre</li>
                                            <li class="condition majuscule"><i class="far fa-check-circle"></i>Votre mot
                                                de passe doit comporter au minimum 1 lettre majuscule</li>
                                            <li class="condition minuscule"><i class="far fa-check-circle"></i>Votre mot
                                                de passe doit comporter au minimum 1 lettre minuscule</li>
                                            <li class="condition speciaux"><i class="far fa-check-circle"></i>Votre mot
                                                de passe doit comporter au minimum 1 caractère spécial</li>
                                            <li class="condition generique"><i class="far fa-check-circle"></i>Votre mot
                                                de passe doit comporter au minimum 8 caractères</li>
                                        </ul>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/app.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            setTimeout(function() {
                if (localStorage.getItem('popState') !== 'shown') {
                    window.notyf.open({
                        type: "success",
                        message: "Get access to all 500+ components and 45+ pages with AdminKit PRO. <u><a class=\"text-white\" href=\"https://adminkit.io/pricing\" target=\"_blank\">More info</a></u> 🚀",
                        duration: 10000,
                        ripple: true,
                        dismissible: false,
                        position: {
                            x: "left",
                            y: "bottom"
                        }
                    });

                    localStorage.setItem('popState', 'shown');
                }
            }, 15000);
        });
    </script>
    {{-- <script>
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm');
    const submitButton = document.getElementById('submitButton');
    const errorMessage = document.getElementById('error-message');

    function validatePasswords(e) {
        e.preventDefault();
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        if (password !== confirm) {
            errorMessage.textContent = "Les mots de passe ne correspondent pas !";
            setTimeout(function() {
                errorMessage.textContent = '';
            }, 5000);
            return false;
        }
        return true;
    }

    confirmInput.addEventListener('input', function() {
        if (passwordInput.value === confirmInput.value) {
            submitButton.disabled = false;
            errorMessage.textContent = "";
        } else {
            submitButton.disabled = true;
        }
    });

    confirmInput.addEventListener('blur', function() {
        if (passwordInput.value !== confirmInput.value) {
            errorMessage.textContent = "Les mots de passe ne correspondent pas !";
            setTimeout(function() {
                errorMessage.textContent = '';
            }, 5000);
        }
    });
</script>
onsubmit="return validatePasswords()" --}}

    <script>
        const passwordInput = document.getElementById('password');
        const conditions = document.querySelectorAll('.condition');

        passwordInput.addEventListener('input', function() {
            const value = this.value;

            let hasNumber = /\d/.test(value);
            let hasUpperCase = /[A-Z]/.test(value);
            let hasLowerCase = /[a-z]/.test(value);
            let hasSpecialCharacter = /[^a-zA-Z0-9]/.test(value);
            let isLongEnough = value.length >= 8;

            conditions.forEach(function(condition) {
                if (condition.classList.contains('chiffre')) {
                    condition.style.color = hasNumber ? 'green' : 'red';
                } else if (condition.classList.contains('majuscule')) {
                    condition.style.color = hasUpperCase ? 'green' : 'red';
                } else if (condition.classList.contains('minuscule')) {
                    condition.style.color = hasLowerCase ? 'green' : 'red';
                } else if (condition.classList.contains('speciaux')) {
                    condition.style.color = hasSpecialCharacter ? 'green' : 'red';
                } else if (condition.classList.contains('generique')) {
                    condition.style.color = isLongEnough ? 'green' : 'red';
                }
            });

            const allConditionsMet = hasNumber && hasUpperCase && hasLowerCase && hasSpecialCharacter &&
                isLongEnough;

            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = !allConditionsMet;
        });
    </script>



</body>

</html>
