@extends('layouts.master')
@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div>
        <h5>Liste des filiales</h5>
        <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
        </div>

        <a class="btn btn-primary" href="{{ route('firm.create') }}" style="width: 7rem;"><i class="align-middle" data-feather="plus"></i>
            Nouveau</a>
    </div>
    <div class="card mt-2" style="padding: 1.5rem;">
        <table class="table table-striped">
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
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Ifu</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($firms as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['telephone'] }}</td>
                    <td>{{ $item['ifu'] }}</td>
                    <td>{{ $item['address'] }}</td>
                    <td><a title="Modifier" class="btn btn-success mr-1 edit-firm" href="{{ route('firm.edit', ['firmId' => $item['enterpriseId']]) }}" ><i class="fas fa-edit"></i></a>
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

    <script>
        $(document).ready(function () {


});
    </script>
@endsection
