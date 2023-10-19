@extends('layouts.lay')
@section('content')
    <div class="back">
        <form method="POST" action="{{ route('handle.some') }}">
            @csrf
            @method('POST')
            <!-- Progress bar -->
            <div class="progressbar">
                <div class="progress" id="progress"></div>

                <div class="progress-step progress-step-active" data-title="Formulaire"></div>
                <div class="progress-step" data-title="Approbation"></div>
                <div class="progress-step" data-title="Accessibilité"></div>
                <div class="progress-step" data-title="Récapitulatif"></div>
            </div>

            <div class="form-step form-step-active">
                <div class="row">
                    <div class="col-sm-12">
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
                            <input id="title" class="form-control form-control-lg" type="text" required="true"
                                name="title" />
                        </div>

                        <div id="builder" class="mt-4 mr-6" style="width: 155vh;">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-8 offset-sm-2">
                            <h3 class="text-center text-muted">Rendu</h3>
                            <div id="formio" class="card card-body bg-light">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-sm-8 offset-sm-2 mt-4">
                        <h3 class="text-center text-muted">Schema Json</h3>
                        <div class="card card-body bg-light jsonviewer">
                            <pre id="json">

                    </pre>
                        </div>
                    </div>
                </div>
                <div class="btns-group d-flex justify-content-end">
                    <a id="suivant" class="bton btn-next btn-primary width-40">Suivant</a>
                </div>
            </div>

            <div class="form-step">
                <h5>Approbateurs par niveaux</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
                <div class="row-md-6 mt-4 mb-3">
                    <div class="d-flex justify-content-between">
                        <a id="ajouter" class="btn btn-success">+ Ajouter</a>
                        <a id="retirer" class="btn btn-danger">- Retirer</a>
                    </div>

                    <div id="conteneur-inputs" class="mt-2">
                        <!-- Les champs de saisie seront ajoutés ici -->

                    </div>
                </div>

                <div class="btns-group d-flex justify-content-between">
                    <a class="bton btn-prev btn-primary width-40">Précédent</a>
                    <a class="bton btn-next btn-primary width-40">Suivant</a>
                </div>
            </div>

            <div class="form-step">
                <h5>Visibilité du formulaire</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
                <div class="mt-3">
                    <div class="col-12">



                    </div>

                    <div class="btns-group d-flex justify-content-between">
                        <a class="bton btn-prev btn-primary width-40">Précédent</a>
                        <a class="bton btn-next btn-primary width-40">Suivant</a>
                    </div>
                </div>
            </div>

            <div class="form-step">
                <h5>Formulaire de congés</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
                <div class="row mt-2">
                    {{-- <div class="col-sm-8 offset-sm-2">
                <div id="formio" class="card card-body bg-light">
                </div>
            </div> --}}
                    <div class="clearfix"></div>
                </div>
                <h5>Approbateurs</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
                <h5>Accessibilité</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>

                <div class="btns-group d-flex justify-content-between">
                    <a class="bton btn-prev btn-primary width-40">Précédent</a>
                    <button id="save" type="submit" class="bton btn-next btn-primary width-40">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>



    <script type="text/javascript">
        var jsonElement = document.getElementById('json');
        var formElement = document.getElementById('formio');
        var subJSON = document.getElementById('subjson');
        let compteurs = {};
        let agreeLevelNumber = 0;
        var builder = new Formio.FormBuilder(document.getElementById("builder"), {
            display: 'form',

        }, {
            builder: {

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

        var setDisplay = function(display) {
            builder.setDisplay(display).then(onReady);
        };

        // Handle the form selection.
        var formSelect = document.getElementById('form-select');
        formSelect.addEventListener("change", function() {
            setDisplay(this.value);
        });

        builder.instance.ready.then(onReady);


        //Manage the dynamic selection
        $(document).ready(function() {
            const ajouterBouton = document.getElementById('ajouter');
            const retirerBouton = document.getElementById('retirer');
            const conteneurInputs = document.getElementById('conteneur-inputs');

            ajouterBouton.addEventListener('click', function(e) {
                e.preventDefault();
                const nouveauCompteur = Object.keys(compteurs).length + 1;
                compteurs[nouveauCompteur] = [];
                const label = document.createElement('label');
                label.textContent = 'Niveau ' + nouveauCompteur;
                agreeLevelNumber = nouveauCompteur;
                const nouvelleListe = document.createElement('select');
                nouvelleListe.classList.add('form-control', 'choices-multiple');
                nouvelleListe.multiple = true;

                const enterpriseId = "{{ session('session.userDto.smartflowEnterprise.enterpriseId') }}";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer {{ session('session.token') }}'
                    }
                });
                // Fetch the list from your API
                $.ajax({
                    url: 'http://192.168.1.11:8080/odsmartflow/manages-persons/list/byEnterprise/' +
                        enterpriseId,
                    type: 'get',
                    success: function(response) {
                        response.forEach(option => {
                            const optionElement = document.createElement('option');
                            optionElement.value = option.personId;
                            optionElement.textContent = option.lastName + ' ' + option
                                .firstName;
                            nouvelleListe.appendChild(optionElement);
                        });

                        // Refresh Bootstrap Select to update the new options
                        //$('.selectpicker').selectpicker('refresh');
                    },
                    error: function(error) {
                        // Handle the error
                    }
                });

                label.classList.add('mb-2', 'd-block');
                conteneurInputs.appendChild(label);
                conteneurInputs.appendChild(nouvelleListe);
                nouvelleListe.addEventListener('change', function() {
                    const personIds = Array.from(nouvelleListe.selectedOptions).map(option => option
                        .value);
                    compteurs[nouveauCompteur] = personIds;
                });

                // Refresh Bootstrap Select
                //$('.selectpicker').selectpicker('refresh');
            });

            retirerBouton.addEventListener('click', function(e) {
                e.preventDefault();
                const dernierSelect = conteneurInputs.querySelector('select:last-of-type');
                const dernierLabel = conteneurInputs.querySelector('label:last-of-type');

                if (dernierSelect && dernierLabel) {
                    conteneurInputs.removeChild(dernierSelect);
                    conteneurInputs.removeChild(dernierLabel);
                    delete compteurs[Object.keys(compteurs).length];
                }
            });
        });
    </script>

    <script>
        //Send the data to the controller
        $(document).ready(function() {
            $("#save").click(function(e) {
                e.preventDefault();
                var smartJson = document.getElementById('json').innerHTML;
                var title = $('#title').val();
                var viewers = $('#viewers').val();
                //var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var form = {
                    content: smartJson,
                    title: title,
                    viewers: viewers,
                    approvals: compteurs,
                    agreeLevelNumber: agreeLevelNumber
                };
                console.log(form);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('handle.some') }}",
                    type: "post",
                    //headers : {"Content-Type" : "application/json"},
                    data: form,
                    success: function(data) {
                        var url = "{{ route('form.myforms') }}"
                        setTimeout(function() {
                            window.location = url
                        }, 500);
                    },
                    error: function(data) {
                        //     var url="{{ route('form.myforms') }}"
                        // setTimeout(function(){
                        //     window.location=url
                        // },1000);
                        // alert("Une erreur est survenue lors de la sauvegarde");
                    }
                });
            });
        });
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
