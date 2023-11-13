@extends('layouts.layout')
@section('content')
    <input id="token" type="hidden" value="{{ session('session.token') }}" />
    <h5>Nouveau formulaire</h5>
    <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    <div class="container-form">
        @if (session()->has('error'))
            <div class="d-flex justify-content-center mb-1 mt-2">
                <div class="col-md-7">
                    <div class="alert alert-danger alert-outline-coloured alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <b style="font-size: 14px;">{{ Session::get('error') }}</b>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div id="error">

        </div>



        <form id="signUpForm" method="post" action="" enctype="multipart/form-data" class="form">
            @csrf
            <!-- start step indicators -->
            <div class="form-header d-flex mb-4">
                <span class="stepIndicator">Formulaire</span>
                <span class="stepIndicator">Approbateurs</span>
                <span class="stepIndicator">Accessibilité</span>
                <span class="stepIndicator">Récapitulatif</span>
            </div>
            <!-- end step indicators -->

            <!-- step one -->
            <div class="step">
                <div class="row">
                    <div class="col-sm-12" style="overflow: auto;">
                        <h5>Créez un formulaire de type <select class="form-control" id="form-select"
                                style="display: inline-block; width: 150px; height:2rem;">
                                <option value="form">Form</option>
                                <option value="wizard">Wizard</option>
                                <option value="pdf">PDF</option>
                            </select></h5>
                        <div class="mb-2"
                            style="height: 0.3rem; width:4rem; background-color: #222e3c; margin-top: -0.3rem"></div>
                        <div class=" mb-3">
                            <label class="form-label">Titre</label>
                            <input id="title" class="form-control form-control-lg class" type="text" required="true"
                                name="title" />
                        </div>

                        <div id="builder" class="mt-4 mr-6" style="width: 155vh;">
                        </div>
                    </div>

                    <div class="col-sm-8 offset-sm-2 mt-4">
                        <div class="card card-body bg-light jsonviewer hidden">
                            <pre id="json">

                    </pre>
                        </div>
                    </div>

                </div>
            </div>

            <!-- step two -->
            <div class="step">
                <h5>Approbateurs par niveaux</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
                <div class="row-md-6 mt-4 mb-3">
                    <div class="d-flex justify-content-between">
                        <a id="ajouter" class="btn btn-success">+ Ajouter</a>
                        <a id="retirer" class="btn btn-danger">- Retirer</a>
                    </div>

                    <div id="conteneur-inputs" class="mt-2">

                    </div>
                </div>
            </div>

            <!-- step three -->
            <div class="step">

                <h5>Visibilité du formulaire</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
                <div class="mt-4 mb-4">
                    <select id="viewers" name="viewers[]" class="form-control choices-multiple" multiple>
                        @foreach ($viewers as $item)
                            <option value="{{ $item['personId'] }}">{{ $item['lastName'] }} {{ $item['firstName'] }}
                            </option>
                        @endforeach
                    </select>

                </div>

            </div>

            <!-- step four -->
            <div class="step">
                <!-- Élément HTML où vous souhaitez afficher le JSON -->
                <div id="formio" class="card card-body bg-light">
                </div>

                <h5>Approbateurs</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>


                <div id="monFormulaire" class="mt-1">
                    <!-- Les champs de saisie seront ajoutés ici -->

                </div>


                <h5>Accessibilités</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>

                <ul id="selectedViewers">
                    <!-- Les personnes sélectionnées seront affichées ici -->
                </ul>
            </div>


            <!-- start previous / next buttons -->
            <div class="form-footer d-flex">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
                <button type="button" id="nextBtn" class="enregistrer-button" onclick="nextPrev(1)">Suivant</button>
            </div>
            <!-- end previous / next buttons -->
        </form>
    </div>
    <style>
        #signUpForm {
            width: 1150px;
            background-color: #ffffff;
            margin: 30px auto;
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
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

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
                console.log(n);
                document.getElementById("nextBtn").innerHTML = "Enregistrer";
                var ajaxExecuted = false; // Drapeau pour vérifier si la requête AJAX a été exécutée

            } else {
                document.getElementById("nextBtn").innerHTML = "Suivant";
            }


            // console.log(n);
            if (n == 2) {
                var formulaire = document.getElementById('monFormulaire');
                if (formulaire.childElementCount == 0) {
                    for (const niveauKey in display) {
                        if (display.hasOwnProperty(niveauKey)) {
                            // Obtenez le tableau de valeurs correspondant à cette clé (niveau)
                            const niveauValeurs = display[niveauKey];

                            // Créez un élément HTML <h4> pour afficher le niveau
                            const h6 = document.createElement('h6');
                            h6.textContent = 'Niveau ' + niveauKey;

                            // Créez une liste HTML <ul> pour afficher les valeurs du niveau
                            const ul = document.createElement('ul');

                            // Parcourez les valeurs du niveau et ajoutez-les à la liste
                            for (let j = 0; j < niveauValeurs.length; j++) {
                                const valeur = niveauValeurs[j];
                                const li = document.createElement('li');
                                li.textContent = valeur;
                                ul.appendChild(li);
                            }

                            // Ajoutez le <h4> et <ul> au conteneur
                            formulaire.appendChild(h6);
                            formulaire.appendChild(ul);
                        }
                    }
                } else {
                    formulaire.innerHTML = '';
                    for (const niveauKey in display) {
                        if (display.hasOwnProperty(niveauKey)) {
                            // Obtenez le tableau de valeurs correspondant à cette clé (niveau)
                            const niveauValeurs = display[niveauKey];

                            // Créez un élément HTML <h4> pour afficher le niveau
                            const h6 = document.createElement('h6');
                            h6.textContent = 'Niveau ' + niveauKey;

                            // Créez une liste HTML <ul> pour afficher les valeurs du niveau
                            const ul = document.createElement('ul');

                            // Parcourez les valeurs du niveau et ajoutez-les à la liste
                            for (let j = 0; j < niveauValeurs.length; j++) {
                                const valeur = niveauValeurs[j];
                                const li = document.createElement('li');
                                li.textContent = valeur;
                                ul.appendChild(li);
                            }

                            // Ajoutez le <h4> et <ul> au conteneur
                            formulaire.appendChild(h6);
                            formulaire.appendChild(ul);
                        }
                    }
                };



                var selectViewers = document.getElementById('viewers');
                var selectedViewersList = document.getElementById('selectedViewers');

                // Ajoutez un gestionnaire d'événements pour détecter les sélections
                selectViewers.addEventListener('change', function() {
                    // Supprimez d'abord tous les éléments actuels de la liste des personnes sélectionnées
                    while (selectedViewersList.firstChild) {
                        selectedViewersList.removeChild(selectedViewersList.firstChild);
                    }

                    // Bouclez à travers les options sélectionnées dans le <select>
                    for (var i = 0; i < selectViewers.options.length; i++) {
                        var option = selectViewers.options[i];
                        if (option.selected) {
                            // Créez un élément <li> pour chaque option sélectionnée
                            var listItem = document.createElement('li');
                            listItem.textContent = option.textContent;
                            selectedViewersList.appendChild(listItem);
                        }
                    }
                });
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

                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("step");
            y = x[currentTab].getElementsByClassName("class");
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

        $(document).ready(function() {

        });
    </script>
    <script type="text/javascript">
        var jsonElement = document.getElementById('json');
        var formElement = document.getElementById('formio');


        var builder = new Formio.FormBuilder(document.getElementById("builder"), {
            display: 'form',

        }, {
            builder: {
                custom: {
                    title: 'Pre-Defined Fields',
                    weight: 10,
                    components: {
                        firstName: {
                            title: 'First Name',
                            key: 'firstName',
                            icon: 'terminal',
                            schema: {
                                label: 'First Name',
                                type: 'textfield',
                                key: 'firstName',
                                input: true
                            }
                        },
                        lastName: {
                            title: 'Last Name',
                            key: 'lastName',
                            icon: 'terminal',
                            schema: {
                                label: 'Last Name',
                                type: 'textfield',
                                key: 'lastName',
                                input: true
                            }
                        },
                        email: {
                            title: 'Email',
                            key: 'email',
                            icon: 'at',
                            schema: {
                                label: 'Email',
                                type: 'email',
                                key: 'email',
                                input: true
                            }
                        },
                        phoneNumber: {
                            title: 'Mobile Phone',
                            key: 'mobilePhone',
                            icon: 'phone-square',
                            schema: {
                                label: 'Mobile Phone',
                                type: 'phoneNumber',
                                key: 'mobilePhone',
                                input: true
                            }
                        }
                    }
                }
            }
        });


        var onForm = function(form) {
            form.on('change', function() {
                subJSON.innerHTML = '';
                subJSON.appendChild(document.createTextNode(JSON.stringify(form.submission, null, 4)));
            });
        };

        var onBuild = function(build) {
            jsonElement.innerHTML = '';
            formElement.innerHTML = '';
            jsonElement.appendChild(document.createTextNode(JSON.stringify(builder.instance.schema, null, 4)));
            Formio.createForm(formElement, builder.instance.form).then(onForm);
        };

        var onReady = function() {
            var jsonElement = document.getElementById('json');
            var formElement = document.getElementById('formio');
            builder.instance.on('change', onBuild);
        };
        // console.log(onReady)



        var setDisplay = function(display) {
            builder.setDisplay(display).then(onReady);
        };

        // Handle the form selection.
        var formSelect = document.getElementById('form-select');
        formSelect.addEventListener("change", function() {
            setDisplay(this.value);
        });

        builder.instance.ready.then(onReady);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Choices(document.querySelector(".choices-multiple"), {
                allowHTML: true
            });
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
