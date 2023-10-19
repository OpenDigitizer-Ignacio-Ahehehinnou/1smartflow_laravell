@extends('layouts.lay')
@section('content')
    <h5>{{ $myform['name'] }}</h5>
    <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    <input id="content" name="content" type="hidden" value="{{ $myform['content'] }}" />
    <input id="title" name="title" type="hidden" value="{{ $myform['name'] }}" />
    <input id="formId" name="formId" type="hidden" value="{{ $myform['formId'] }}" />
    <input id="agreeLevelNumber" name="agreeLevelNumber" type="hidden" value="{{ $myform['agreeLevelNumber'] }}" />
    <input id="token" type="hidden" value="{{ session('session.token') }}" />

    <form method="POST" action="{{ route('document.handle.create') }}">
        @csrf
        @method('POST')
        <!-- Progress bar -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>

            <div class="progress-step progress-step-active" data-title="Document"></div>
            <div class="progress-step" data-title="Approbateurs"></div>
            <div class="progress-step" data-title="Récapitulatif"></div>
        </div>

        <div class="form-step form-step-active">
            <h5>Document</h5>
            <div id="formio"></div>
            <div class="btns-group d-flex justify-content-end">
                <a id="agreement" class="bton btn-next btn-primary width-40">Suivant</a>
            </div>
        </div>
        <div class="form-step">
            <h5>Approbateurs par niveaux</h5>
            <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
            <div id="conteneur" class="row-md-6 mt-4 mb-3">

            </div>

            <div class="btns-group d-flex justify-content-between">
                <a class="bton btn-prev btn-primary width-40">Précédent</a>
                <a id="nextOne" class="bton btn-next btn-primary width-40">Suivant</a>
            </div>
        </div>
        <div class="form-step">

            <h5>Approbateurs</h5>
            <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
            <div id="monFormulaire" class="mt-1">

            </div>
            <div class="btns-group d-flex justify-content-between">
                <a class="bton btn-prev btn-primary width-40">Précédent</a>
                <button id="save" type="submit" class="bton btn-next btn-primary width-40">Enregistrer</button>
            </div>
        </div>
    </form>

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

            //$(document).ready(function() {
            $("#agreement").click(function(e) {
                e.preventDefault();
                const conteneur = $('#conteneur');
                var mainContainer = document.getElementById('conteneur');
                if (conteneur.children().length === 0) {

                    // for (var i = 1; i <= agreeLevelNumber; i++) {
                    //(function(level) {
                    // Fetch the list from your API for each level
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'),
                            'Authorization': token
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
                                console.log(selectedUsersByLevel);
                                console.log(selectedLabelsByUsers);
                            });

                        },
                        error: function(error) {
                            console.log(
                                'Erreur lors de la récupération des données');
                        }
                    });

                } else {

                }
            });



            // });

            $(document).ready(function() {
                Formio.createForm(document.getElementById('formio'), form).then(function(form) {
                    // Prevent the submission from going to the form.io server.
                    form.nosubmit = true;
                    form.on('submit', function(submission) {
                        data = submission;
                        console.log(data);
                        if (data === null){
                            alert(1);
                        }
                    });
                });
            });


            nextButton.addEventListener('click', function(e) {
                e.preventDefault;
                console.log('What the fuck');
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
            });

        });
    </script>


    <script>
        //Send the data to the controller
        $(document).ready(function() {
            $("#save").click(function(e) {
                e.preventDefault();
                var doc = {
                    content: JSON.stringify(data['data']),
                    name: title,
                    formId: formId,
                    approvals: selectedUsersByLevel,
                    agreeLevelNumber: agreeLevelNumber
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('document.handle.create') }}",
                    type: "post",
                    data: doc,
                    success: function(data) {
                        var url = "{{ route('document.created', ['page' => 0]) }}"
                        setTimeout(function() {
                            window.location = url
                        }, 500);
                    },
                    error: function(data) {

                    }
                });
            });
        });
    </script>
@endsection
