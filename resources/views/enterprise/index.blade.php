@extends('layouts.master')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <div>
        <h5>Informations sur l'entreprise</h5>
        <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    </div>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Modifier
        </button>
    </div>



</div>
<main class="content mt-n5">
    <div class="container p-0">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">

                    <div class="card-header" style="background-color: #999ea3 ">

                    </div>
                    <table class="table">
                        <thead>

                            <tr>
                                <th scope="col" style="font-weight: bolder">Raison Sociale</th>
                                <td scope="col">{{ $enterprise['name'] }}</td>
                            </tr>

                            <tr>
                                <th scope="col">Responsable</th>
                                <td scope="col">{{ $enterprise['manager'] }}</td>
                            </tr>

                            <tr>
                                <th scope="col">Adresse</th>
                                <td scope="col">{{ $enterprise['address'] }}</td>
                            </tr>

                            <tr>
                                <th scope="col">Email</th>
                                <td scope="col">{{ $enterprise['email'] }}</td>
                            </tr>

                            <tr>
                                <th scope="col">Ifu</th>
                                <td scope="col">{{ $enterprise['ifu'] }}</td>
                            </tr>

                            <tr>
                                <th scope="col">Téléphone</th>
                                <td scope="col">{{ $enterprise['telephone'] }}</td>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>


    </div>
</main>


<!-- Modal -->
<!-- Modal de modification -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modifier les informations</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="msg200"></div>
                <!-- Formulaire de modification -->
                <form>
                    <div class="row">
                        <input type="text" class="form-control" id="enterpriseId"
                            value="{{ $enterprise['enterpriseId']}}" name="enterpriseId" hidden>

                        <div class=" col-md-6 mb-1">
                            <label for="editRaisonSociale" class="form-label">Raison Sociale</label>
                            <input type="text" class="form-control" id="name" value="{{ $enterprise['name']}}"
                                name="name">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="editResponsable" class="form-label">Responsable</label>
                            <input type="text" class="form-control" id="manager" value="{{ $enterprise['manager'] }}"
                                name="manager">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label for="editResponsable" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="address" value="{{ $enterprise['address'] }}"
                                name="address">
                        </div>
                        <div class=" col-md-6 mb-1">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $enterprise['email'] }}"
                                name="email">
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-1">
                            <label for="editResponsable" class="form-label">Numéro d'identification fiscale</label>
                            <input type="text" class="form-control" id="ifu" value="{{ $enterprise['ifu'] }}"
                                name="ifu">
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="editResponsable" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="telephone"
                                value="{{ $enterprise['telephone'] }}" name="telephone">
                        </div>
                    </div>


                    <div class="row" hidden >

                        <div class="mb-3 col-md-6">
                            <label for="exampleInputPassword1" class="form-label">createdBy</label>

                            <input type="text" class="form-control" id="createdBy"
                                value="{{ $enterprise['createdBy'] }}" name="createdBy">

                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="activationStatus" class="form-label">createdAt</label>
                            <input type="text" class="form-control" id="createdAt"
                                value="{{ $enterprise['createdAt'] }}" name="createdAt">
                        </div>


                    </div>

                    <div class="row"hidden>

                        <div class="mb-3 col-md-4">
                            <label for="activationStatus" class="form-label">softDeleteAt</label>
                            <input type="text" class="form-control" id="softDeleteAt"
                                value="{{ $enterprise['softDeleteAt'] }}" name="softDeleteAt">
                        </div>


                        <div class="mb-3 col-md-4">
                            <label for="updatedBy" class="form-label">updatedBy</label>
                            <input type="text" class="form-control" value="{{ $enterprise['updatedBy'] }}"
                                id="updatedBy" name="updatedBy">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="softDeletedBy" class="form-label">softDeletedBy</label>
                            <input type="text" class="form-control" value="{{ $enterprise['softDeletedBy'] }}"
                                id="softDeletedBy" name="softDeletedBy">
                        </div>

                    </div>

                    <div class="row" hidden >

                        <div class="mb-3 col-md-6">
                            <label for="activationStatus" class="form-label">updatedAt</label>
                            <input type="text" class="form-control" id="updatedAt"
                                value="{{ $enterprise['updatedAt'] }}" name="updatedAt">
                        </div>


                        <div class="mb-3 col-md-6">
                            <label for="deletedFlag" class="form-label">deletedFlag</label>
                            <input type="text" class="form-control" value="{{ $enterprise['deletedFlag'] }}" id="deletedFlag" name="deletedFlag">
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
    $(document).ready(function () {
        // Lorsque le bouton "Envoyer" est cliqué
        $("#modif").click(function () {
            // Récupérez les données des champs "nom" et "ville"
            var name = $("#name").val();
            var address = $("#address").val();
            var ifu = $("#ifu").val();
            var telephone = $("#telephone").val();
            var email = $("#email").val();
            var manager = $("#manager").val();
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
                name,address,ifu,telephone,email,manager,deletedFlag,enterpriseId,softDeletedBy,updatedBy,softDeleteAt,updatedAt,createdAt,createdBy
            };

            // Envoyez les données au contrôleur via une requête AJAX
            $.ajax({
                type: "PUT",
                url: "{{ route('enterprise.update')}}",
                data: donneesAEnvoyer,
                success: function (response) {

                    if(parseInt(response)==200 || parseInt(response)==500){

                        parseInt(response)==500?($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                            <strong>Une erreur s'est produite</strong> veuillez réessayez.

                            </div>`)
                        ):($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                            <strong> Les informations de l'entreprise ont été modifiées avec succès. </strong>

                            </div>`)
                        );
                    }

                    var url="{{route('enterprise.index')}}"
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



@endsection
