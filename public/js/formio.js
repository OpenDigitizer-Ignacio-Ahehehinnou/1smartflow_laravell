
var subJSON = document.getElementById('subjson');
let compteurs = {};
let display = {};
let agreeLevelNumber = 0;
const ajouterBouton = document.getElementById('ajouter');
const retirerBouton = document.getElementById('retirer');
const conteneurInputs = document.getElementById('conteneur-inputs');
const nextOne = document.getElementById('nextOne');
const token = document.getElementById('token');



$(() => {


    ajouterBouton.addEventListener('click', function (e) {
        e.preventDefault();
        var nouveauCompteur = Object.keys(compteurs).length + 1;
        compteurs[nouveauCompteur] = [];
        display[nouveauCompteur] = [];
        var label = document.createElement('label');
        label.textContent = 'Niveau ' + nouveauCompteur;
        agreeLevelNumber = nouveauCompteur;
        var nouvelleListe = document.createElement('select');

        nouvelleListe.classList.add('form-control', 'choices-multiple');
        nouvelleListe.multiple = true;

        var enterpriseId = "{{ session('session.userDto.smartflowEnterprise.enterpriseId') }}";
        $.ajaxSetup({
            headers: {
                //'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': token
            }
        });
        // Fetch the list from your API
        $.ajax({
            url: "http://127.0.0.1:8000/form/ignacio",
            type: 'get',
            success: function (response) {
                if (typeof response === 'object') {
                    var keys = Object.keys(response);
                    // alert(keys);
                    console.log(response);
                    keys.forEach(key => {
                        var personList = response[key];
                        // console.log(personList);
                        // var firstPerson = personList[];
                        // console.log(firstPerson);
                        for (var i = 0; i < personList.length; i++) {
                            var person = personList[i];
                            if (person) {
                                var personId = person.personId;
                                var firstName = person.firstName;
                                var lastName = person.lastName;
                                var optionElement = document.createElement(
                                    'option');
                                //console.log(optionElement);

                                optionElement.value = person.personId;
                                optionElement.textContent = person.lastName +
                                    ' ' + person.firstName;
                                nouvelleListe.appendChild(optionElement);

                            }
                        }
                        // Ensuite, utilisez personList ici ou effectuez d'autres opérations
                        //utiliserPersonList(personList);
                    });
                } else {

                    //alert('La conversion en objet a échoué.');
                }
                // Refresh Bootstrap Select to update the new options
                // $('.selectpicker').selectpicker('refresh');
            },

            error: function (error) {
                // Handle the error
                $('#error').html(`<div class="alert alert-danger alert-outline-coloured alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    <div class="alert-message">
                        <strong>Une erreur est survenue!</strong> Veuillez réessayer!
                    </div>
                </div>`);
                // alert('La conversion en objet a échoué.');
            },
        });

        label.classList.add('mb-2', 'd-block');
        conteneurInputs.appendChild(label);
        conteneurInputs.appendChild(nouvelleListe);
        nouvelleListe.addEventListener('change', function () {
            var personIds = Array.from(nouvelleListe.selectedOptions).map(option => option
                .value);
            var personInfo = Array.from(nouvelleListe.selectedOptions).map(option => option
                .textContent);
            compteurs[nouveauCompteur] = personIds;
            display[nouveauCompteur] = personInfo;
        });

        // Refresh Bootstrap Select
        //$('.selectpicker').selectpicker('refresh');
    });

    retirerBouton.addEventListener('click', function (e) {
        e.preventDefault();
        console.log('Try this');
        const dernierSelect = conteneurInputs.querySelector('select:last-of-type');
        const dernierLabel = conteneurInputs.querySelector('label:last-of-type');
        if (dernierSelect && dernierLabel) {
            conteneurInputs.removeChild(dernierSelect);
            conteneurInputs.removeChild(dernierLabel);
            delete compteurs[Object.keys(compteurs).length];
            delete display[Object.keys(display).length];
            //console.log(display);
        }
    });


    $('#nextBtn').on('click', function () {
        if ($(this).html() === 'Enregistrer') {
            var save = document.getElementById('nextBtn');
            save.addEventListener('click', function () {

                var smartJson = document.getElementById('json').innerHTML;
                var title = $('#title').val();
                var viewers = $('#viewers').val();
                save.disabled = true;
                $.ajax({
                    url: "http://127.0.0.1:8000/handle/some",
                    type: "POST",
                    data: {
                        title: title,
                        viewers: viewers,
                        agreeLevelNumber: agreeLevelNumber,
                        approvals: compteurs,
                        content: smartJson,
                    },
                   success: function (data) {
                        window.location = "http://127.0.0.1:8000/form/myforms/0";
                    }
                });
            });


        }
    });
    //  });

});
