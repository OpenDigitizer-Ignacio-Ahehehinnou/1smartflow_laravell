@extends('layouts.master')
@section('content')
    <div class=" mb-3">
        <h5>Profil</h5>
        <div style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Personnel</h5>
                </div>
                <div class="card-body text-center">
                    {{-- <img src="img/avatars/avatar-4.jpg" alt="{{ $firstName }} {{ $lastName }}" --}} {{--
                    class="img-fluid rounded-circle mb-2" width="128" height="128" /> --}}
                    <h5 class="card-title mb-0">{{ $lastName }} {{ $firstName }}</h5>
                    <div class="text-muted mb-2">{{ $function }}</div>
                </div>


                <hr class="my-0" />
                <div class="card-body">
                    <h5 class="h6 card-title">Profil</h5>
                    {{-- <p id="id">{{$personId}}</p> --}}
                    {{-- <p><b>Nom : </b>{{ $lastName }} </p>
                <p><b>Prénom (s) : </b>{{ $firstName }} </p> --}}
                    <p><b>Email : </b>{{ $username }} </p>
                    <p><b>Téléphone : </b>{{ $telephone }} </p>
                    <p><b>Signature : </b> </p>

                    <img id="signature-image" src="{{ $signature }}" alt="Signature">

                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-header">

                    <h5 class="card-title mb-0">Entreprise</h5>
                </div>
                <div class="card-body h-100">

                    <p><b>Entreprise : </b>{{ $enterprise }} </p>
                    <p><b>Fonction : </b>{{ $function }} </p>
                    {{-- <p><b>Rôle : </b>{{ $role }} </p> --}}
                </div>
            </div>
            <div id="msg200"></div>
            {{-- <div class="signature-container"> --}}
            <canvas id="signature-canvas" class="signature-container" width="400" height="200"></canvas>
            <input type="hidden" id="id" value="{{ $personId}}" >
            {{--
        </div> --}}
            <button id="clear-signature" class="btn btn-danger btn-sm">Effacer la signature</button>
            <button id="save-signature" class="btn btn-success btn-sm">Enregistrer la signature</button>
        </div>

    </div>

    {{-- CSS DE LA SIGNATURE --}}
    <style>
        .signature-container {
            border: 2px solid #000;
            /* Bordure noire de 2 pixels */
            width: 475px;
            /* Largeur réduite */
            height: 165px;
            position: relative;
            /* Permet de positionner les boutons par rapport au cadre */
            margin-bottom: 10px;
            /* Espacement entre le cadre et les boutons */
            margin-top: 10px;
            /* Espacement au-dessus du cadre */
            display: flex;
            /* Utilisation de flexbox pour aligner les boutons en haut */
            align-items: flex-start;
            /* Aligner les boutons en haut */
            justify-content: space-between;
            /* Espacement automatique entre les boutons */
        }
    </style>

    {{-- ENREGISTRER SIGNATURE --}}

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

            $('#clear-signature').on('click', function() {
                context.clearRect(0, 0, canvas.width, canvas.height);
            });

            $('#save-signature').on('click', function() {
                //  const signatureDataURL = canvas.toDataURL();
                var id= $('#id').val();
                alert(id)
                const signatureDataURL = canvas.toDataURL();
                const randomSignature = generateRandomSignature();


                $.ajax({
                    type: 'GET',
                    url: "{{ route('signature.save') }}",
                    data: {
                        signature: signatureDataURL,
                        randomSignature: randomSignature,
                        id: id
                    },
                    success: function(response) {
                        console.log(response.message);

                        if (parseInt(response) == 200 || parseInt(response) == 500) {

                            parseInt(response) == 500 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                                    <strong>Une erreur s'est produite</strong> veuillez réessayez.

                                    </div>`)) : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                                    <strong> Signature enregistrée avec succès. </strong>

                                    </div>`));
                        }

                        var url = "{{ route('auth.profile') }}"
                        if (response == 200) {
                            setTimeout(function() {
                                window.location = url
                            }, 2000)
                        } else {
                            $("#msg200").html(response);

                        }

                    },
                    error: function(error) {
                        console.error('Erreur lors de l\'enregistrement de la signature',
                        error);
                    }
                });
            });

            function generateRandomSignature() {
                const timestamp = new Date().getTime(); // Obtenez le timestamp actuel
                const random = Math.random(); // Générez un nombre aléatoire
                const uniqueId = `${timestamp}-${random}`; // Combinez-les pour créer un identifiant unique

                return uniqueId;
            }


        });
    </script>

    {{-- AFFICHER LA SIGNATURE --}}
    <script>
        // Écoutez l'événement clic sur un élément HTML avec l'ID "get-signature"
        $('#get-signature').on('click', function() {
            // Récupérez l'identifiant de la signature à partir d'une source appropriée
            var id = $('#id').val();
            alert(id)
            const signatureId = id /* Récupérez l'identifiant de la signature que vous souhaitez afficher */ ;
            //alert(signatureId)
            var url = "{{ route('signature.recup') }}";

            // Effectuez une requête AJAX de type GET pour récupérer la signature
            $.ajax({
                type: 'GET',
                url: url, // Remplacez par l'URL de votre route Laravel
                data: {
                        id: id
                    },
                success: function(response) {
                    //alert(20)
                    // Vérifiez si la réponse contient une signature
                    if (response.signature) {
                        // Récupérez la signature (probablement une URL de données)
                        const signatureDataURL = response.signature;
                        const signaturePersonId = response.personId;

                        if(signaturePersonId=== id){
                        // Affichez la signature dans une image
                        const imageElement = document.getElementById('signature-image');
                        imageElement.src = signatureDataURL;
                        imageElement.alt = 'Signature'; // Texte alternatif pour l'image

                        // Facultatif : affichez un message de succès ou effectuez d'autres actions
                        alert('Signature récupérée avec succès');
                        }else{ alert("tu es un boss")}
                    } else {
                        // La réponse ne contient pas de signature, affichez un message d'erreur
                        console.error('La signature n\'a pas pu être récupérée.');
                    }
                },
                error: function(error) {
                    // Gestion des erreurs en cas d'échec de la requête
                    console.error('Erreur lors de la récupération de la signature', error);
                }
            });
        });
    </script>
@endsection
