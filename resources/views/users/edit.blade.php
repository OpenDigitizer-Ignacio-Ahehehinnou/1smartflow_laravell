@extends("layouts.master")
@section('content')

<h5>Modifier un utilisateur</h5>
<div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
<div class="d-flex justify-content-center mt-3">
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Modification</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('user.update',  ['personId' => $person['personId']]) }}">
            @csrf
            @method('PUT')

            <div class="row">
            <div class="col mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" value="{{ $person['lastName'] }}" name="lastname" required="true">
            </div>
            <div class="col mb-3">
                <label class="form-label">Prénom(s)</label>
                <input type="text" class="form-control" value="{{ $person['firstName'] }}" name="firstname" required="true">
            </div>
            </div>
            <div class="row">
            <div class="col mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="{{ $person['username'] }}" name="email" required="true">
            </div>
            <div class="col mb-3">
                <label class="form-label">Téléphone</label>
                <input type="text" class="form-control" value="{{ $person['telephone'] }}" name="phone" required="true">
            </div>
            </div>
            <div class="row">
            <div class="col mb-3">
                <label class="form-label">Fonction</label>
                <select class="form-control mb-3" name="functionId">
                    <option selected>Choisir une fonction</option>
                    @foreach ($functions as $item)
                    <option value="{{ $item['functionId'] }}" {{ $person['functionId'] === $item['functionId'] ? 'selected' : '' }}>{{ $item['libelle'] }}</option>
                    {{-- <option value="{{ $item['roleId'] }}" {{ $person['roleId'] === $item['roleId'] ? 'selected' : '' }}>{{ $item['label'] }}</option> --}}

                    @endforeach
                </select>

            </div>
            <div class="col mb-3">
                <label class="form-label">Rôle</label>
                <select class="form-control mb-3" name="roleId">
                    <option selected>Choisir un rôle</option>
                    @foreach ($roles as $item)
                    <option value="{{ $item['roleId'] }}" {{ $person['roleId'] === $item['roleId'] ? 'selected' : '' }}>{{ $item['label'] }}</option>
                    @endforeach


                </select>
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>
</div>
@endsection
