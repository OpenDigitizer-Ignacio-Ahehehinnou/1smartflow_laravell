@extends('layouts.master')
@section('content')
    <main>
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h5>Rôles & privilèges</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
            </div>
            <button type="button" class=" btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#exampleModal1">Ajouter</button>
        </div>

        <div class="card mt-2" style="padding: 1.5rem">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Description</th>
                        <th>Crée par</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $item)
                        <tr>
                            <td>{{ $item['label'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td>{{ $item['createdBy'] }}</td>
                            <td hidden> @php
                                $rightLabels = [];
                                foreach ($item['listOfSmartflowRight'] as $right) {
                                    $rightLabels[] = $right['rightId'];
                                }
                                echo implode(', ', $rightLabels);
                            @endphp</td>

                            <td><a title="Modifier" href="" class="btn btn-success mr-1 edit-role"
                                    data-role-id="{{ $item['roleId'] }}" data-label="{{ $item['label'] }}"
                                    data-description="{{ $item['description'] }}"
                                    data-rights="{{ implode(', ', $rightLabels) }}"><i class="fas fa-edit"></i></a>

                                {{-- <a title="Supprimer" href="{{ route('role.delete', ['roleId' => $item['roleId']]) }}"
                            class="btn btn-danger"><i class="fas fa-trash"></i></a> --}}

                                <a href="" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#confirmationModal"><i class="fas fa-trash"></i></a>

                            </td>
                        </tr>

                        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                            aria-labelledby="confirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation de suppression</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer ce rôle ?
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Non</button>
                                        <a href="{{ route('role.delete', ['roleId' => $item['roleId']]) }}"
                                            class="btn btn-danger">Oui</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    </main>



    <!-- Modal de modification -->
    <div class="modal fade" id="roleModale" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier rôle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="msg200"></div>
                    <!-- Formulaire de modification -->
                    <form>
                        <div class="row">
                            <input type="text" class="form-control" id="roleId" hidden name="roleId">

                            <div class=" col-md-12 mb-1">
                                <label for="label" class="form-label">Label</label>
                                <input type="text" class="form-control" id="label" name="label">
                            </div>

                        </div>

                        <div class="row">
                            <input type="text" class="form-control" id="roleId" hidden name="roleId">

                            <div class=" col-md-12 mb-1">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-mf-12 mb-1">
                                <label for="right" class="form-label">Privilèges</label>
                                <select id="rights" name="rights[]" class="form-control choices-multiple" multiple>
                                    @foreach ($rights as $item)
                                        <option value="{{ $item['rightId'] }}">{{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-1">
                                <label for="selectedRights" class="form-label">Privilèges Sélectionnés</label>
                                <textarea class="form-control choices-multiple" name="selectedRights[]" id="selectedRights"></textarea>
                            </div>
                            {{-- readonly --}}
                        </div>

                        <div class="row" hidden>
                            <div class="col-md-4 mb-1">
                                <label for="enterpriseId" class="form-label">Entreprise</label>
                                <input type="text" class="form-control" id="enterpriseId" value="1"
                                    name="enterpriseId">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="exampleInputPassword1" class="form-label">createdBy</label>

                                <input type="text" class="form-control" id="createdBy" value="ignacio@gmail.com"
                                    name="createdBy">

                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="activationStatus" class="form-label">createdAt</label>
                                <input type="text" class="form-control" id="createdAt" value="1690976267544"
                                    name="createdAt">
                            </div>
                        </div>

                        <div class="row" hidden>
                            <div class="mb-3 col-md-4">
                                <label for="activationStatus" class="form-label">softDeleteAt</label>
                                <input type="text" class="form-control" id="softDeleteAt" value="azerty"
                                    name="softDeleteAt">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="updatedBy" class="form-label">updatedBy</label>
                                <input type="text" class="form-control" value="azerty" id="1692950440044"
                                    name="updatedBy">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="softDeletedBy" class="form-label">softDeletedBy</label>
                                <input type="text" class="form-control" value="" id="softDeletedBy"
                                    name="softDeletedBy">
                            </div>

                        </div>

                        <div class="row" hidden>
                            <div class="mb-3 col-md-6">
                                <label for="activationStatus" class="form-label">updatedAt</label>
                                <input type="text" class="form-control" id="updatedAt"
                                    value="hans.oloukpona-yinnon@opendigitizer.com" name="updatedAt">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="deletedFlag" class="form-label">deletedFlag</label>
                                <input type="text" class="form-control" value="a" id="deletedFlag"
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

    <!-- Modal de création -->
    <form method="POST" action="{{ route('role.create') }}">
        @csrf
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Créer un rôle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulaire de création -->
                        <form>
                            <div class="mb-1">
                                <label for="label" class="form-label">Libellé</label>
                                <input type="text" class="form-control" id="label" name="label">
                            </div>
                            <div class="mb-1">
                                <label for="right" class="form-label">Privilèges</label>
                                <select id="droits" name="rights[]" class="form-control choices-multiple" multiple>
                                    @foreach ($rights as $item)
                                        <option value="{{ $item['rightId'] }}">{{ $item['label'] }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-1">
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    </form>




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Choices(document.querySelector(".choices-multiple"), {
                allowHTML: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".edit-role").click(function(e) {

                e.preventDefault()

                var roleId = $(this).data("role-id");
                var label = $(this).data("label");
                var description = $(this).data("description");
                var rights = $(this).data('rights');
                // alert(rights)
                // alert(roleId)

                // Injectez la valeur du libellé dans l'input "libelle" du modal
                $("#label").val(label);
                $("#description").val(description);
                var ty = $("#selectedRights").val(rights);
                //alert(ty)
                $("#roleId").val(roleId);

                // Affichez le formulaire modal
                $("#roleModale").modal("show");
            });

            var previousSelectedRights = []; // Stockez la sélection précédente
            var rightsData = {
                @foreach ($rights as $item)
                    "{{ $item['rightId'] }}": "{{ $item['label'] }}",
                @endforeach
            };

            // Lorsque le champ de sélection multiple change
            $("#rights").change(function() {
                // Récupérez les droits sélectionnés
                var selectedRights = $("#rights").val();

                // Comparez la sélection actuelle avec la sélection précédente
                var removedRights = previousSelectedRights.filter(function(right) {
                    return !selectedRights.includes(right);
                });

                // Obtenez les `rightId` correspondant aux droits sélectionnés
                var selectedRightIds = selectedRights.map(function(rightId) {
                    return rightId;
                });

                // Récupérez le contenu existant du textarea
                var existingContent = $("#selectedRights").val();

                // Séparez le contenu existant en libellés individuels
                var existingLabels = existingContent.split(',').map(function(label) {
                    return label.trim();
                });

                // Supprimez les droits retirés du champ de sélection multiple du contenu existant
                removedRights.forEach(function(removedRight) {
                    existingLabels = existingLabels.filter(function(label) {
                        return label !== removedRight;
                    });
                });

                // Fusionnez les nouveaux `rightId` avec les anciens en supprimant les doublons
                var allIds = [...existingLabels, ...selectedRightIds];
                var uniqueIds = [...new Set(allIds)];

                // Mettez à jour le contenu du textarea avec les `rightId` uniques
                $("#selectedRights").val(uniqueIds.join(', '));

                // Mettez à jour la sélection précédente
                previousSelectedRights = selectedRights;
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            // Lorsque le bouton "Envoyer" est cliqué
            $("#modif").click(function() {
                // Récupérez les données des champs "nom" et "ville"

                var roleId = $("#roleId").val();
                var label = $("#label").val();
                var description = $("#description").val();
                var selectedRights = $("#selectedRights").val();

                var createdBy = $("#createdBy").val();
                var createdAt = $("#createdAt").val();
                var updatedAt = $("#updatedAt").val();
                var softDeleteAt = $("#softDeleteAt").val();
                var updatedBy = $("#updatedBy").val();
                var softDeletedBy = $("#softDeletedBy").val();
                var enterpriseId = $("#enterpriseId").val();
                var deletedFlag = $("#deletedFlag").val();
                var listOfSmartflowRightId = $("#rights").val();

                // alert(description)
                // alert(label)
                // Récupérer le jeton CSRF depuis la balise meta
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

               // alert(tableauDonnees)
                // Créez un objet JSON contenant toutes les données
                var donneesAEnvoyer = {
                    _token: csrfToken,
                    selectedRights,
                    roleId,
                    label,
                    listOfSmartflowRightId,
                    description,
                    deletedFlag,
                    enterpriseId,
                    softDeletedBy,
                    updatedBy,
                    softDeleteAt,
                    updatedAt,
                    createdAt,
                    createdBy
                };
                //alert(donneesAEnvoyer)

                // Envoyez les données au contrôleur via une requête AJAX
                $.ajax({
                    type: "PUT",
                    url: "{{ route('role.update') }}",
                    data: donneesAEnvoyer,
                    success: function(response) {

                        if (parseInt(response) == 200 || parseInt(response) == 500) {

                            parseInt(response) == 500 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                            <strong>Une erreur s'est produite</strong> veuillez réessayez.

                            </div>`)) : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                            <strong> Le rôle a été modifié avec succès. </strong>

                            </div>`));
                        }

                        var url = "{{ route('role.index') }}"
                        if (response == 200) {
                            setTimeout(function() {
                                window.location = url
                            }, 1000)
                        } else {
                            $("#msg200").html(response);

                        }
                    },

                });
            });

        });
    </script>
@endsection
