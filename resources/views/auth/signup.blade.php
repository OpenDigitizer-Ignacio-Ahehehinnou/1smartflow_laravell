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
    <link href="{{ asset('css/password.css') }}" rel="stylesheet">
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


    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <p class="lead" style="font-size: 12px;">
                                Créez plus facilement vos documents avec smartflow.
                            </p>
                        </div>
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
                        <div class="back">
                            <div class="card-body">
                                <div class="container-form">
                                    <form id="signUpForm" method="POST" action="{{ route('auth.handle.register') }}"
                                        class="form">
                                        @csrf
                                        <input id="signature" type="hidden" name="person_signature" value="" />
                                        <!-- start step indicators -->
                                        <div class="form-header d-flex mb-4">
                                            <span class="stepIndicator">Entreprise</span>
                                            <span class="stepIndicator">Administrateur</span>
                                            <span class="stepIndicator">Signature</span>
                                            <span class="stepIndicator">Mot de passe</span>
                                        </div>
                                        <!-- end step indicators -->

                                        <!-- step one -->
                                        <div class="step">
                                            <p class="text-center mb-4">Informations sur la filiale</p>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label class="form-label">Raison sociale</label>
                                                    <input type="text" placeholder="" oninput="this.className = ''"
                                                        name="enterprise_name" value="{{ old('enterprise_name') }}">
                                                </div>
                                                <div class="col mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" placeholder="" oninput="this.className = ''" onblur="validateEmail(this)"
                                                        name="enterprise_email" value="{{ old('enterprise_email') }}">
                                                        <p id="email-error-msg" style="color: red;font-size:12px;"></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label class="form-label">Ifu</label>
                                                    <input type="text" placeholder="" oninput="this.className = ''" onkeypress="return isNumberKey(event)"
                                                        name="enterprise_ifu" value="{{ old('enterprise_ifu') }}">
                                                </div>
                                                <div class="col mb-3">
                                                    <label class="form-label">Adresse</label>
                                                    <input type="text" placeholder="" oninput="this.className = ''"
                                                        name="enterprise_adress" value="{{ old('enterprise_adress') }}">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Téléphone</label>
                                                <input type="text" placeholder="" oninput="this.className = ''" onkeypress="return isNumberKey(event)"
                                                    name="enterprise_phone" value="{{ old('enterprise_phone') }}">
                                            </div>
                                        </div>

                                        <!-- step two -->
                                        <div class="step">
                                            <p class="text-center mb-4">Informations sur l'administrateur</p>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label class="form-label">Nom</label>
                                                    <input type="text" placeholder="" onkeypress="return isLetterKey(event)"
                                                        oninput="this.className = ''" name="person_lastname"
                                                        value="{{ old('person_lastname') }}">
                                                </div>
                                                <div class="col mb-3">
                                                    <label class="form-label">Prénom(s)</label>
                                                    <input type="text" placeholder="" onkeypress="return isLetterKey(event)"
                                                        oninput="this.className = ''" name="person_firstname"
                                                        value="{{ old('person_firstname') }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <label class="form-label">Téléphone</label>
                                                    <input type="text" placeholder="" onkeypress="return isNumberKey(event)"
                                                        oninput="this.className = ''" name="person_phone"
                                                        value="{{ old('person_phone') }}">
                                                </div>
                                                <div class="col mb-3">
                                                    <label class="form-label">Fonction</label>
                                                    <input type="text" placeholder=""
                                                        oninput="this.className = ''" name="person_function"
                                                        value="{{ old('person_function') }}">
                                                </div>
                                            </div>
                                            <div class="col mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" placeholder="" onblur="validateEmail(this)" oninput="this.className = ''"
                                                    name="person_username" value="{{ old('person_username') }}">
                                                    <p id="email-error-msg" style="color: red;font-size:12px;"></p>
                                            </div>
                                        </div>

                                        <div class="step">
                                            <p class="text-center mb-4">Entrez votre signature</p>
                                            <div class="row">
                                                <canvas id="signature-canvas" class="signature-container"
                                                    style="border: 1px solid #0d6efd; border-radius: 6px;"
                                                    width="300" height="130"></canvas>

                                                <div class="d-flex justify-content-start mt-3 mb-4">
                                                    <a id="clear" class="bton btn-danger btn-sm">Effacer
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- step three -->
                                        <div class="step">
                                            <p class="text-center mb-4">Définissez un mot de passe</p>
                                            <div class="mb-3">
                                                <label class="form-label">Mot de passe</label>
                                                <input id="password" type="password"
                                                    placeholder="Entrez votre mot de passe"
                                                    oninput="this.className = ''" name="person_password">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Confirmez le mot de passe</label>
                                                <input id="confirm_password" type="password"
                                                    placeholder="Confirmer le mot de passe"
                                                    oninput="this.className = ''" name="confirm_password">
                                            </div>
                                            <div class="validator-criters mb-1">
                                                <span class="chiffre"><i class="far fa-check-circle"></i> &nbsp;Votre
                                                    mot de passe doit comporter au minimum 1 chiffres</span>
                                                <span class="majuscule"><i class="far fa-check-circle"></i>
                                                    &nbsp;Votre mot de passe doit comporter au minimum 1 lettre
                                                    majuscule</span>
                                                <span class="minuscule"><i class="far fa-check-circle"></i>
                                                    &nbsp;Votre mot de passe doit comporter au minimum 1 lettre
                                                    minuscule</span>
                                                <span class="speciaux"><i class="far fa-check-circle"></i>
                                                    &nbsp;Votre mot de passe doit comporter au minimum 1 caractère
                                                    spécial</span>
                                                <span class="generique"><i class="far fa-check-circle"></i>
                                                    &nbsp;Votre mot de passe doit comporter au minimum 8
                                                    caractères</span>
                                            </div>
                                        </div>

                                        <!-- step four -->



                                        <!-- start previous / next buttons -->
                                        <div class="form-footer d-flex">
                                            <button type="button" id="prevBtn"
                                                onclick="nextPrev(-1)">Précédent</button>
                                            <button type="button" id="nextBtn"
                                                onclick="nextPrev(1)">Suivant</button>
                                        </div>
                                        <!-- end previous / next buttons -->
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

    </main>

    </div>

    <style>
        #signUpForm {
            max-width: 1000px;
            background-color: #ffffff;
            margin: 40px auto;
            padding: 40px;
            box-shadow: 0px 6px 18px rgb(0 0 0 / 9%);
            border-radius: 12px;
        }

        #signUpForm .form-header {
            gap: 5px;
            text-align: center;
            font-size: 12px;
        }

        #signUpForm .form-header .stepIndicator {
            position: relative;
            flex: 1;
            padding-bottom: 30px;
        }

        #signUpForm .form-header .stepIndicator.active {
            font-weight: 600;
        }

        #signUpForm .form-header .stepIndicator.finish {
            font-weight: 600;
            color: #144194;
        }

        #signUpForm .form-header .stepIndicator::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            z-index: 9;
            width: 20px;
            height: 20px;
            background-color: #d5efed;
            border-radius: 50%;
            border: 3px solid #ecf5f4;
        }

        #signUpForm .form-header .stepIndicator.active::before {
            background-color: #0d6efd;
            border: 3px solid #89cfff;
        }

        #signUpForm .form-header .stepIndicator.finish::before {
            background-color: #0c5ae9;
            border: 3px solid #0d6efd;
        }

        #signUpForm .form-header .stepIndicator::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 8px;
            width: 100%;
            height: 3px;
            background-color: #f3f3f3;
        }

        #signUpForm .form-header .stepIndicator.active::after {
            background-color: #89cfff;
        }

        #signUpForm .form-header .stepIndicator.finish::after {
            background-color: #0c5ae9;
        }

        #signUpForm .form-header .stepIndicator:last-child:after {
            display: none;
        }

        #signUpForm input {
            padding: 10px 15px;
            width: 100%;
            font-size: 1em;
            border: 1px solid #e3e3e3;
            border-radius: 5px;
        }

        #signUpForm input:focus {
            border: 1px solid #0d6efd;
            outline: 0;
        }

        #signUpForm input.invalid {
            border: 1px solid #dc3545;
        }

        #signUpForm .step {
            display: none;
        }

        #signUpForm .form-footer {
            overflow: auto;
            gap: 20px;
        }

        #signUpForm .form-footer button {
            background-color: #0d6efd;
            border: 1px solid #0d6efd !important;
            color: #ffffff;
            border: none;
            padding: 13px 30px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            margin-top: 5px;
        }

        #signUpForm .form-footer button:hover {
            opacity: 0.8;
        }

        #signUpForm .form-footer #prevBtn {
            background-color: #fff;
            color: #0d6efd;
        }
    </style>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function isLetterKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    // Permet les lettres majuscules et minuscules (A-Z, a-z) ainsi que les caractères spéciaux
    if ((charCode < 65 || (charCode > 90 && charCode < 97) || charCode > 122) && !isSpecialCharacter(charCode)) {
        return false;
    }
    return true;
}

function isSpecialCharacter(charCode) {
    // Liste de codes de caractères spéciaux que vous souhaitez autoriser
    var specialCharacters = [32, 33, 64, 35, 36, 37, 94, 38, 42, 40, 41, 95, 43, 45, 61, 123, 125, 91, 93, 58, 59, 34, 39, 60, 62, 44, 46, 47, 63];
    return specialCharacters.includes(charCode);
}
</script>
<script>

    function validateEmail(input) {
        var email = input.value;
        var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if (email.match(emailRegex)) {
            document.getElementById("email-error-msg").innerText = "";
        } else {
            document.getElementById("email-error-msg").innerText = "Veuillez saisir une adresse e-mail valide.";
            setTimeout(function() {
                input.value = '';
                document.getElementById("email-error-msg").innerText = '';
            }, 3000);
        }
    }
</script>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab
        const submit = document.getElementById("nextBtn");

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("step");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                //
                document.getElementById("nextBtn").innerHTML = "Enregistrer";
                console.log("Last level");

            } else {
                document.getElementById("nextBtn").innerHTML = "Suivant";
            }
            if (n == x.length) {
                document.getElementById("nextBtn").type = "submit";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("step");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("signUpForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("step");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("stepIndicator")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("stepIndicator");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
        $(() => {
            if (submit.innerHTML == "Enregistrer") {
                submit.type = "submit";
            }
        });
    </script>

    <script src="{{ asset('js/register.js') }}"></script>

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

            $('#nextBtn').on('click', function() {
                const signatureDataURL = canvas.toDataURL();
                const signatureInput = document.getElementById('signature');
                signatureInput.value = signatureDataURL;
            });
        });
    </script>
</body>

</html>
