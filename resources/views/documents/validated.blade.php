@extends('layouts.doclay')
@section('content')
    <div class="mb-3">
        <h5>Liste des documents validés</h5>
        <div style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    </div>
    <div class="card mt-2" style="padding: 1.5rem">
        <table class="table table-striped" style="width:100%">
            <div class="d-flex justify-content-end">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <form method="POST" action="{{ route('document.search1')}}" >

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
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($validated as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimestampMs($item['createdAt'])->format('d-m-Y H:i:s') }}</td>
                        <td><a title="Consulter"
                                href="{{ route('document.preview', ['documentId' => $item['documentId']]) }}"
                                class="btn btn-primary mr-1"><i class="fas fa-eye"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-2">
            <div class="">
                @if ($numberOfElements == 0)
                    <p>Pas d'éléments</p>
                @endif

                @if ($numberOfElements != 0)
                    <p>Affichage de 1 à {{ $numberOfElements }} lignes</p>
                @endif
            </div>
            <div class="">
                <h6>Page {{ $current + 1 }}</h6>
            </div>
            <div class="">
                @if ($current >= 1)
                    <a class="btn btn-primary" href="{{ route('user.index', ['page' => $current - 1]) }}">Précédent</a>
                @endif

                @if ($current < $totalPages - 1)
                    <a class="btn btn-primary" href="{{ route('user.index', ['page' => $current + 1]) }}">Suivant</a>
                @endif
            </div>
        </div>
    </div>
@endsection
