var formulaire = document.getElementById('monFormulaire');
var subJSON = document.getElementById('subjson');
let compteurs = {};
let display = {};
let agreeLevelNumber = 0;
const ajouterBouton = document.getElementById('ajouter');
const retirerBouton = document.getElementById('retirer');
const conteneurInputs = document.getElementById('conteneur-inputs');
const nextOne = document.getElementById('nextOne');
const token = document.getElementById('token');
const firstNext = document.getElementById('suivant');



$(() => {

    //Manage the dynamic selection
 //$(document).ready(function() {


    ajouterBouton.addEventListener('click', function(e) {
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
            success: function(response) {
                if (typeof response === 'object') {
                    var keys = Object.keys(response);
                    // alert(keys);
                    console.log(response);
                    keys.forEach(key => {
                        var personList = response[key];
                        console.log(personList);
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
                    alert('La conversion en objet a échoué.');
                }
                // Refresh Bootstrap Select to update the new options
                // $('.selectpicker').selectpicker('refresh');
            },

            error: function(error) {
                // Handle the error
            },
        });

        label.classList.add('mb-2', 'd-block');
        conteneurInputs.appendChild(label);
        conteneurInputs.appendChild(nouvelleListe);
        nouvelleListe.addEventListener('change', function() {
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


    nextOne.addEventListener('click', function(e) {
        e.preventDefault;
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
        }
    });

    firstNext.addEventListener('click', function(e) {
        e.preventDefault;
        var title2 = $('#title').val();
        if(title2 === null){
            //firstNext.setAttribute('disabled', 'disabled');
            e.preventDefault();
        }
    });

    retirerBouton.addEventListener('click', function(e) {
        e.preventDefault();
        const dernierSelect = conteneurInputs.querySelector('select:last-of-type');
        const dernierLabel = conteneurInputs.querySelector('label:last-of-type');
        if (dernierSelect && dernierLabel) {
            conteneurInputs.removeChild(dernierSelect);
            conteneurInputs.removeChild(dernierLabel);
            delete compteurs[Object.keys(compteurs).length];
            delete display[Object.keys(display).length];
            console.log(display);
        }
    });

//});

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



        $("#createForm").on('submit', (e) => {
            e.preventDefault();
            var smartJson = document.getElementById('json').innerHTML;
            var title = $('#title').val();
            var viewers = $('#viewers').val();

            $.ajax({
                url: "http://127.0.0.1:8000/handle/some",
                type: "POST",
                data: { //content : smartJson,
                    title: title,
                    viewers : viewers,
                    agreeLevelNumber: agreeLevelNumber,
                    approvals: compteurs,
                    content: smartJson,
                },
                success: function(data) {
                    window.location = "http://127.0.0.1:8000/form/myforms/0";
                }
            });
        });
});
