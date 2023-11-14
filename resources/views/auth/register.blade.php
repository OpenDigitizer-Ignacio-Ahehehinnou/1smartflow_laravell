<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />

    <title>Inscription | Smartflow</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
</head>

<body style="background-color: white">


            <main class="d-flex w-100" >
                <div class="container d-flex flex-column">
                    <div class="row vh-100">
                        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                            <div class="d-table-cell align-middle">
                                <div class="text-center mt-4">
                                    <p class="lead" style="font-size: 12px;">
                                        Créez plus facilement vos documents avec smartflow.
                                    </p>
                                </div>

                                <div class="back">
                                    <div class="card-body">
                                        <div class="container-form">
                                            <form method="POST" action="{{ route('auth.handle.register') }}" class="form">
                                                @csrf
                                                <h3 class="text-center" style="font-weight: 800">Inscription | Smartflow</h3>
                                                <!-- Progress bar -->
                                                <div class="progressbar">
                                                    <div class="progress" id="progress"></div>

                                                    <div class="progress-step progress-step-active" data-title="Entreprise">
                                                    </div>
                                                    <div class="progress-step" data-title="Responsable"></div>
                                                    <div class="progress-step" data-title="Signature"></div>
                                                    <div class="progress-step" data-title="Mot de passe"></div>
                                                    <div class="progress-step" data-title="Récapitulatif"></div>

                                                </div>

                                                <!-- Steps -->
                                                <div class="form-step form-step-active">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label class="form-label">Raison sociale</label>
                                                                <input class="form-control form-control-lg" type="text"
                                                                    required="true" name="enterprise_name" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input class="form-control form-control-lg" type="email"
                                                                    required="true" name="enterprise_email" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Ifu</label>
                                                                <input class="form-control form-control-lg" type="text"
                                                                    required="true" name="enterprise_ifu" />
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label class="form-label">Adresse</label>
                                                                <input class="form-control form-control-lg" type="text"
                                                                    required="true" name="enterprise_adress" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Téléphone</label>
                                                                <input class="form-control form-control-lg" type="number"
                                                                    required="true" name="enterprise_phone" />
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="">
                                                        <a class="btn btn-next width-40 ml-auto">Suivant</a>
                                                    </div>
                                                </div>
                                                <div class="form-step">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nom</label>
                                                                <input class="form-control form-control-lg" type="text"
                                                                    name="person_lastname" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Téléphone</label>
                                                                <input class="form-control form-control-lg" type="number"
                                                                    name="person_phone" />
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <label class="form-label">Prénom(s)</label>
                                                                <input class="form-control form-control-lg" type="text"
                                                                    name="person_firstname" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Fonction</label>
                                                                <input class="form-control form-control-lg" type="text"
                                                                    name="person_function" />
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input class="form-control form-control-lg" type="email"
                                                                name="person_username" />
                                                        </div>
                                                        <div class="btns-group d-flex justify-content-between">
                                                            <a href="#" class="btn btn-prev width-40">Précédent</a>
                                                            <a href="#" class="btn btn-next width-40">Suivant</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-step">
                                                    <div class="row">
                                                        <canvas id="signature-canvas" class="signature-container"
                                                            style="border: 1px solid #0d6efd; border-radius: 8px;"
                                                            width="400" height="175"></canvas>
                                                            <input id="signature" type="hidden" name="signature" value=""/>
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <a id="clear" class="bton btn-danger btn-sm">Effacer
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="btns-group d-flex justify-content-between mt-2">
                                                        <a href="#" class="btn btn-prev width-40">Précédent</a>
                                                        <a href="#" id="save"
                                                            class="btn btn-next width-40">Suivant</a>
                                                    </div>

                                                </div>
                                                <div class="form-step">
                                                    <div class="row">
                                                        <div class="col block-input mb-2">
                                                            <label class="form-label">Mot de passe</label>
                                                            <input id="password" class="form-control form-control-lg"
                                                                type="password" name="person_password" />
                                                            <small></small>
                                                        </div>
                                                        <div class="col mb-2">
                                                            <label class="form-label">Confirmation </label>
                                                            <input id="confirm_password" class="form-control form-control-lg"
                                                                type="password" name="confirm_password" />
                                                            <small></small>
                                                        </div>
                                                    </div>
                                                    <div class="validator-criters">
                                                        <span class="chiffre"><i class="far fa-check-circle"></i> &nbsp;Votre
                                                            mot de passe doit comporter au minimum 1 chiffres</span><br>
                                                        <span class="majuscule"><i class="far fa-check-circle"></i>
                                                            &nbsp;Votre mot de passe doit comporter au minimum 1 lettre
                                                            majuscule</span><br>
                                                        <span class="minuscule"><i class="far fa-check-circle"></i>
                                                            &nbsp;Votre mot de passe doit comporter au minimum 1 lettre
                                                            minuscule</span><br>
                                                        <span class="generique"><i class="far fa-check-circle"></i>
                                                            &nbsp;Votre mot de passe doit comporter au minimum 6
                                                            caractères</span>
                                                    </div>

                                                    <div class="btns-group d-flex justify-content-between">
                                                        <a href="#" class="btn btn-prev width-40">Précédent</a>
                                                        <a href="#" class="btn btn-next width-40">Suivant</a>
                                                    </div>

                                                </div>

                                                <div class="form-step">

                                                    <div class="btns-group d-flex justify-content-between">
                                                        <a href="#" class="btn btn-prev width-40">Précédent</a>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-next mt-2">Enregistrer</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

            </main>

    </div>
    <script src="{{ asset('js/register.js') }}"></script>
    <script src="{{ asset('js/form.js') }}"></script>

    <script>
        $(document).ready(function() {
            const canvas = document.getElementById('signature-canvas');
            const context = canvas.getContext('2d');
            let isDrawing = false;

            canvas.addEventListener('mousedown', () => {
                isDrawing = true;
                context.beginPath();
            });

            canvas.addEventListener('mousemove', (e) => {
                if (!isDrawing) return;
                context.lineWidth = 2;
                context.lineCap = 'round';
                context.strokeStyle = 'black';

                const x = e.clientX - canvas.getBoundingClientRect().left;
                const y = e.clientY - canvas.getBoundingClientRect().top;

                context.lineTo(x, y);
                context.stroke();
            });

            canvas.addEventListener('mouseup', () => {
                isDrawing = false;
                context.closePath();
            });

            $('#clear').on('click', function() {
                context.clearRect(0, 0, canvas.width, canvas.height);
            });

            $('#save').on('click', function() {
                const signatureDataURL = canvas.toDataURL();
                const signatureInput = document.getElementById('signature');
                signatureInput.value = signatureDataURL;
            });
        });


    </script>
</body>

</html>
