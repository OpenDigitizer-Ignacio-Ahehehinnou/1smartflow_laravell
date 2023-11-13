@extends('layouts.master')
@section('content')
@if(session()->has("success"))
<div class="alert alert-success" >
    <h3>{{session()->get('success')}}</h3>
</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
<div class="alert alert-danger" >
    <ul >
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>

        @endforeach
    </ul>
    </div>
@endif
<div class="d-flex justify-content-between mb-3">
    <div>
<h5>Liste des utilisateurs</h5>
<div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    </div>
<a class="btn btn-primary" href="{{route('user.create')}}">Nouveau</a>
</div>

<div class="card mt-2" style="padding: 1.5rem">
    <table  class="table table-striped" style="width:100%">
        <div class="d-flex justify-content-end">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <form method="POST" action="{{ route('person.search')}}" >
                        @csrf
                        <input id="search" class="form-control form-control-md" type="text" placeholder="Rechercher..."
                        name="search" />
                        <button class="btn btn-primary btn-md" type="submit">Rechercher</button>
                    </form>
                </div>
            </div>
        </div>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item )
            <tr>
                <td>{{$item['lastName']}}</td>
                <td>{{$item['firstName']}}</td>
                <td>{{$item['username']}}</td>
                <td>{{$item['telephone']}}</td>
                <td><a title="Modifier" href="{{ route('user.edit', ['personId' => $item['personId']]) }}" class="btn btn-success mr-1"><i class="fas fa-edit"></i></a>
                    <a title="Supprimer" href="" data-key="{{ $item['personId'] }}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i></a></td>
            </tr>
            @endforeach

        </tbody>

    </table>
    <div class="d-flex justify-content-between mt-2">
        <div class="">
            <p>Affichage de 1 à {{ $numberOfElements}} lignes</p>
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

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="user">
        <div class="modal-content">
            <form method="POST" action="{{ route('user.delete') }}">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <p class="mb-0">Voulez vous vraiment supprimer ce utilisateur ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="personId" id="personId" value="">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                <button type="submit" class="btn btn-danger">Oui</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
     document.addEventListener("DOMContentLoaded", function() {

$('#deleteModal').on('show.bs.modal', function(e) {
    var button = $(e.relatedTarget);
    var deleteId = button.data('key');
    var modal = $(this);
    modal.find('#personId').val(deleteId);
})
     });
</script>
@endsection
