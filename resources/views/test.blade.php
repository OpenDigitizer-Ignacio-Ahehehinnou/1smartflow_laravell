@extends('layouts.lay')
@section('content')
    <input id="content" name="content" type="hidden" value="{{ $myform['content'] }}" />
    <input id="title" name="title" type="hidden" value="{{ $myform['name'] }}" />
    <input id="formId" name="formId" type="hidden" value="{{ $myform['formId'] }}" />
    <input id="agreeLevelNumber" name="agreeLevelNumber" type="hidden" value="{{ $myform['agreeLevelNumber'] }}" />
    <input id="token" type="hidden" value="{{ session('session.token') }}" />
    <h5>{{ $myform['name'] }}</h5>
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
                <span class="stepIndicator">Document</span>
                <span class="stepIndicator">Approbateurs</span>
                <span class="stepIndicator">Récapitulatif</span>
            </div>
            <!-- end step indicators -->

            <!-- step one -->
            <div class="step">
                <div id="formio"></div>

            </div>

            <!-- step two -->
            <div class="step">
                <div id="conteneur" class="row-md-6 mt-4 mb-3">

                </div>
            </div>

            <!-- step three -->
            <div class="step">
                <div id="monFormulaire" class="mt-1">

                </div>
            </div>

            <!-- start previous / next buttons -->
            <div class="form-footer d-flex">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
            </div>
            <!-- end previous / next buttons -->
        </form>
    </div>
    <style>
        #signUpForm {
            max-width: 1150px;
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
        var content = $('#content').val();
        var title = $('#title').val();
        var formId = $('#formId').val();
        var agreeLevelNumber = $('#agreeLevelNumber').val();
        var selectedUsersByLevel = {};
        var selectedLabelsByUsers = {};
        let data = {};
        var agreeLevel = 0;

        const nextButton = document.getElementById('nextOne');
        var token = $('#token').val();


        $(() => {

            var form = JSON.parse(content);
            const agreementButton = document.getElementById('agreement');
            //const mainContainer = document.getElementById('conteneur');

            $(document).ready(function() {
                Formio.createForm(document.getElementById('formio'), form).then(function(form) {
                    // Prevent the submission from going to the form.io server.
                    form.nosubmit = true;
                    form.on('submit', function(submission) {
                        data = submission;
                        console.log(data);
                        if (data === null) {
                            alert(1);
                        }
                    });
                });
            });


            $('#nextBtn').on('click', function() {
            if ($(this).html() === 'Enregistrer') {
                var save = document.getElementById('nextBtn');
                save.addEventListener('click', function() {
                    var doc = {
                        content: JSON.stringify(data['data']),
                        name: title,
                        formId: formId,
                        approvals: selectedUsersByLevel,
                        agreeLevelNumber: agreeLevelNumber,
                    };
                    console.log(doc);
                    //save.disabled = true;
                    throw new Error("La condition est vraie, le code s'arrête ici.");
                    $.ajax({
                        url: "http://127.0.0.1/document/handle/create",
                        type: "POST",
                        data: doc,
                        success: function(data) {
                            //var url = "{{ route('document.created', ['page' => 0]) }}"
                           // setTimeout(function() {
                                window.location = "http://127.0.0.1:8000/document/created/0";

                        }
                       /* error: function(data) {
                            $('#error').html(`<div class="alert alert-danger alert-outline-coloured alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    <div class="alert-message">
                        <strong>Une erreur est survenue!</strong> Veuillez réessayer!
                    </div>
                </div>`);
                        }*/
                    });
                });
            }
        });

        });



        var currentTab = 0; // Current tab is set to be the first tab (0)
        const submit = document.getElementById('nextBtn');
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("step");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
                $("#nextBtn").click(function(e) {
                    e.preventDefault();
                    const conteneur = $('#conteneur');
                    var mainContainer = document.getElementById('conteneur');
                    if (conteneur.children().length === 0) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content'),
                            }
                        });
                        $.ajax({
                            url: 'http://127.0.0.1:8000/approval/persons/' + formId + '/' +
                                agreeLevelNumber,
                            type: 'get',
                            success: function(response) {
                                var test = response['persons'];
                                //console.log(test);
                                for (var key in test) {
                                    if (test.hasOwnProperty(key)) {
                                        var label = document.createElement('h6');
                                        label.textContent = key;
                                        label.classList.add('mt-1')
                                        // Créer un select pour le niveau
                                        var select = document.createElement(
                                            'select');
                                        select.classList.add('form-control',
                                            'choices-multiple', 'mb-2');
                                        select.multiple = true;
                                        //selectedUsersByLevel[key] = [];
                                        var users = test[key];
                                        for (var i = 0; i < users.length; i++) {
                                            var user = users[i];
                                            var option = document.createElement(
                                                "option");
                                            option.value = user.personId;
                                            option.textContent = user.lastName + ' ' +
                                                user.firstName;
                                            select.appendChild(option);
                                        }

                                        mainContainer.appendChild(label);
                                        mainContainer.appendChild(select);

                                    }
                                }

                                // Fonction pour supprimer les clés vides du dictionnaire
                                function removeEmptyKeys(dict) {
                                    for (var key in dict) {
                                        if (dict.hasOwnProperty(key)) {
                                            if (dict[key].length === 0) {
                                                delete dict[key];
                                            }
                                        }
                                    }
                                };

                                mainContainer.addEventListener('change', function(
                                    event) {
                                    var target = event.target;
                                    if (target.tagName === 'SELECT') {
                                        var selectedOptions = Array.from(target
                                            .selectedOptions);
                                        var selectedUserIds = selectedOptions
                                            .map(option => option.value);
                                        // Récupérez le niveau associé à ce select en remontant jusqu'à l'élément parent h6
                                        var selectedKey = target
                                            .previousElementSibling.textContent;
                                        // Utilisez une expression régulière pour extraire le numéro de la clé
                                        var match = selectedKey.match(/\d+/);
                                        var selectedNumber = match ? match[0] :
                                            null;
                                        // Associez les IDs des personnes sélectionnées au niveau dans le dictionnaire
                                        selectedUsersByLevel[selectedNumber] =
                                            selectedUserIds;


                                        // Associez les libellés aux noms et prénoms des utilisateurs sélectionnés
                                        var selectedLabels = selectedOptions
                                            .map(option => option.textContent);
                                        selectedLabelsByUsers[selectedKey] =
                                            selectedLabels;

                                    }
                                    removeEmptyKeys(selectedUsersByLevel);
                                    removeEmptyKeys(selectedLabelsByUsers);
                                    // console.log(selectedUsersByLevel);
                                    //console.log(selectedLabelsByUsers);
                                });

                            },
                            error: function(error) {
                                console.log(
                                    'Erreur lors de la récupération des données');
                                $('#error').html(`<div class="alert alert-danger alert-outline-coloured alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    <div class="alert-message">
                        <strong>Une erreur est survenue!</strong> Veuillez réessayer!
                    </div>
                </div>`);
                            }
                        });

                    } else {

                    }
                });
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == 1) {
                //console.log("Affiche ceci");

            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Enregistrer";
                var approve = document.getElementById('monFormulaire');
                if (approve.childElementCount == 0) {
                    for (const niveauKey in selectedLabelsByUsers) {
                        if (selectedLabelsByUsers.hasOwnProperty(niveauKey)) {
                            // Obtenez le tableau de valeurs correspondant à cette clé (niveau)
                            const niveauValeurs = selectedLabelsByUsers[niveauKey];
                            // Créez un élément HTML <h4> pour afficher le niveau
                            const h6 = document.createElement('h6');
                            h6.textContent = niveauKey;
                            // Créez une liste HTML <ul> pour afficher les valeurs du niveau
                            const ul = document.createElement('ul');

                            // Parcourez les valeurs du niveau et ajoutez-les à la liste
                            for (let j = 0; j < niveauValeurs.length; j++) {
                                const valeur = niveauValeurs[j];
                                const li = document.createElement('li');
                                li.textContent = valeur;
                                ul.appendChild(li);
                                //console.log(valeur);
                            }
                            //console.log(niveauValeurs);
                            // Ajoutez le <h4> et <ul> au conteneur
                            approve.appendChild(h6);
                            approve.appendChild(ul);
                            //console.log(approve.appendChild(h6));
                        }
                    }
                } else {
                    approve.innerHTML = '';
                    for (const niveauKey in selectedLabelsByUsers) {
                        if (selectedLabelsByUsers.hasOwnProperty(niveauKey)) {
                            // Obtenez le tableau de valeurs correspondant à cette clé (niveau)
                            const niveauValeurs = selectedLabelsByUsers[niveauKey];

                            // Créez un élément HTML <h4> pour afficher le niveau
                            const h6 = document.createElement('h6');
                            h6.textContent = niveauKey;

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
                            approve.appendChild(h6);
                            approve.appendChild(ul);
                        }
                    }
                }
                //document.getElementById("nextBtn").type = "submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Suivant";
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
    </script>


@endsection
