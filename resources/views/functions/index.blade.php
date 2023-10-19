@extends('layouts.master')
@section('content')
<div class="d-flex justify-content-between mb-2">
    <div>
        <h5>Liste des fonctions</h5>
        <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    </div>
    <button type="button" class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">Ajouter</button>
</div>
<div class="card mt-2" style="padding: 1.5rem">
    <table class="table table-striped" style="width:100%">
        <div class="d-flex justify-content-end">
            <div class="col-md-4">
                <div class="input-group mb-3">
                <input id="search" class="form-control form-control-md" type="text" placeholder="Rechercher..."
                name="search" />
                <button class="btn btn-primary btn-md" type="button">Rechercher</button>
                </div>
            </div>
        </div>
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($functions as $item)
            <tr>

                <td>{{ $item['libelle'] }}</td>
                <td><button title="Modifier" class="btn btn-success mr-1 edit-function" data-function-id="{{ $item['functionId'] }}" data-libelle="{{ $item['libelle'] }}"><i
                            class="fas fa-edit"></i></button>
                        {{-- <a href="{{ route('function.delete', ['functionId' => $item['functionId']]) }}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal"><i class="fas fa-trash"></i></a> --}}
                        <a href="" class="btn btn-danger delete-function" data-key="{{ $item['functionId'] }}" data-bs-toggle="modal" data-bs-target="#confirmationModal"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between mt-2">
        <div class="">
            @if($numberOfElements == 0)
            <p>Pas d'éléments</p>
            @endif

            @if ($numberOfElements != 0)
            <p>Affichage de 1 à {{ $numberOfElements}} lignes</p>
            @endif
        </div>
        <div class="">
            <h6>Page {{ $current + 1 }}</h6>
        </div>
        <div class="">
            @if( $current >= 1)
                <a class="btn btn-primary" href="{{ route('user.index', ['page' => $current - 1]) }}">Précédent</a>
            @endif

            @if($current < $totalPages -1)
                <a class="btn btn-primary" href="{{ route('user.index', ['page' => $current + 1]) }}">Suivant</a>
            @endif
        </div>
    </div>
</div>

{{-- Modal de suppression --}}
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="function">
        <div class="modal-content">
            <form method="POST" action="{{ route('function.delete') }}">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette function ?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="functionId" id="functionId" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                <button type="submit" class="btn btn-danger">Oui</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de création -->
<form method="POST" action="{{ route('function.create') }}">
    @csrf
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Créer une fonction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1">
                        <label for="function" class="form-label">Libellé</label>
                        <input type="text" class="form-control" id="function" name="libelle">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal de modification -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modifier fonction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="msg200"></div>
                <!-- Formulaire de modification -->
                <form>
                    <div class="row">
                        <input type="text" class="form-control" id="functionId" hidden
                            name="functionId" >

                        <div class=" col-md-12 mb-1">
                            <label for="libelle" class="form-label">Libelle</label>
                            <input type="text" class="form-control" id="libelle" name="libelle">
                        </div>


                    </div>


                    <div class="row" hidden>

                        <div class="col-md-4 mb-1">
                            <label for="editResponsable" class="form-label">Entreprise</label>
                            <input type="text" class="form-control" id="enterpriseId"
                                value="{{ $item['enterpriseId'] }}" name="enterpriseId">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="exampleInputPassword1" class="form-label">createdBy</label>

                            <input type="text" class="form-control" id="createdBy" value="{{ $item['createdBy'] }}"
                                name="createdBy">

                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="activationStatus" class="form-label">createdAt</label>
                            <input type="text" class="form-control" id="createdAt" value="{{ $item['createdAt'] }}"
                                name="createdAt">
                        </div>


                    </div>

                    <div class="row" hidden>

                        <div class="mb-3 col-md-4">
                            <label for="activationStatus" class="form-label">softDeleteAt</label>
                            <input type="text" class="form-control" id="softDeleteAt"
                                value="{{ $item['softDeleteAt'] }}" name="softDeleteAt">
                        </div>


                        <div class="mb-3 col-md-4">
                            <label for="updatedBy" class="form-label">updatedBy</label>
                            <input type="text" class="form-control" value="{{ $item['updatedBy'] }}" id="updatedBy"
                                name="updatedBy">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="softDeletedBy" class="form-label">softDeletedBy</label>
                            <input type="text" class="form-control" value="{{ $item['softDeletedBy'] }}"
                                id="softDeletedBy" name="softDeletedBy">
                        </div>

                    </div>

                    <div class="row" hidden>

                        <div class="mb-3 col-md-4">
                            <label for="userIdForLog" class="form-label">userIdForLog</label>
                            <input type="text" class="form-control" id="userIdForLog"
                                value="{{ $item['userIdForLog'] }}" name="userIdForLog">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="activationStatus" class="form-label">updatedAt</label>
                            <input type="text" class="form-control" id="updatedAt" value="{{ $item['updatedAt'] }}"
                                name="updatedAt">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="deletedFlag" class="form-label">deletedFlag</label>
                            <input type="text" class="form-control" value="{{ $item['deletedFlag'] }}" id="deletedFlag"
                                name="deletedFlag">
                        </div>

                    </div>



                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modif">Modifier</button>
            </div>
        </div>
    </div>
</div>


<script>
     document.addEventListener("DOMContentLoaded", function() {

$('#confirmationModal').on('show.bs.modal', function(e) {
    var button = $(e.relatedTarget);
    var functionId = button.data('key');
    var modal = $(this);
    modal.find('#functionId').val(functionId);
})
     });

    $(document).ready(function () {
        $(".edit-function").click(function () {
            var functionId = $(this).data("function-id");
            var libelle = $(this).data("libelle");

            // Injectez la valeur du libellé dans l'input "libelle" du modal
            $("#libelle").val(libelle);
            $("#functionId").val(functionId);

            // Affichez le formulaire modal
            $("#exampleModal").modal("show");
        });
    });

</script>

<script>
    $(document).ready(function () {
        // Lorsque le bouton "Envoyer" est cliqué
        $("#modif").click(function () {
            // Récupérez les données des champs "nom" et "ville"
            var functionId = $("#functionId").val();

            var libelle = $("#libelle").val();
            var userIdForLog = $("#userIdForLog").val();
            var createdBy = $("#createdBy").val();
            var createdAt = $("#createdAt").val();
            var updatedAt = $("#updatedAt").val();
            var softDeleteAt = $("#softDeleteAt").val();
            var updatedBy = $("#updatedBy").val();
            var softDeletedBy = $("#softDeletedBy").val();
            var enterpriseId = $("#enterpriseId").val();
            var deletedFlag = $("#deletedFlag").val();


            // Récupérer le jeton CSRF depuis la balise meta
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            //alert(tableauDonnees)
            // Créez un objet JSON contenant toutes les données
            var donneesAEnvoyer = {
                _token: csrfToken,
                functionId,libelle,userIdForLog,deletedFlag,enterpriseId,softDeletedBy,updatedBy,softDeleteAt,updatedAt,createdAt,createdBy
            };

            // Envoyez les données au contrôleur via une requête AJAX
            $.ajax({
                type: "PUT",
                url: "{{ route('function.edit')}}",
                data: donneesAEnvoyer,
                success: function (response) {

                    if(parseInt(response)==200 || parseInt(response)==500){

                        parseInt(response)==500?($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                            <strong>Une erreur s'est produite</strong> veuillez réessayez.

                            </div>`)
                        ):($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                            <strong> La fonction a été modifiée avec succès. </strong>

                            </div>`)
                        );
                    }

                    var url="{{route('function.index', ['page' => 0])}}"
                    if(response==200){
                        setTimeout(function(){
                            window.location=url
                        },1000)
                    }  else{
                        $("#msg200").html(response);

                        }
                },

            });
        });
    });
</script>

<!-- Inclure jQuery avant votre script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Intercepte le clic sur les liens de suppression avec la classe "delete-function"
    $(".delete-function").click(function(e) {
        e.preventDefault(); // Empêche le comportement par défaut du lien

        // Récupère l'URL du lien de suppression
        var deleteUrl = $(this).attr("href");
        var libelle = $('#libelle').val();

        // Affichez votre modal de confirmation ici s'il y en a un

        // Effectue une requête AJAX pour supprimer l'élément
        $.ajax({
            url: deleteUrl,libelle
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Assurez-vous d'avoir une balise meta CSRF dans votre modèle
            },
            success: function(response) {

                alert('valider')
            },
            error: function(error) {
                alert('erreur')
                // Traitez les erreurs ici, par exemple, affichez un message d'erreur
            }
        });
    });
});
</script>


@endsection
