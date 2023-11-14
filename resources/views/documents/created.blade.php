@extends('layouts.doclay')
@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            <h3>{{ session()->get('success') }}</h3>
        </div>
    @endif


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <div>
            <h5>Liste des documents crées</h5>
            <div style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
        </div>
        <a class="btn btn-primary" href="{{ route('document.new') }}" style="width: 7rem;"><i class="align-middle"
                data-feather="plus"></i> Nouveau</a>
    </div>
    <div class="card mt-2" style="padding: 1.5rem">
        <table class="table table-striped" style="width:100%">
            <div class="d-flex justify-content-end">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <form method="POST" action="{{ route('document.search')}}" >

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
                @foreach ($created as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimestampMs($item['createdAt'])->format('d-m-Y H:i:s') }}</td>
                        <td><a title="Modifier" href="{{ route('document.edit', ['documentId' => $item['documentId']]) }}"
                                class="btn btn-success mr-1"><i class="fas fa-edit"></i></a>
                            <a title="Initier" data-key="{{ $item['documentId'] }}" data-bs-toggle="modal" data-key=""
                                data-bs-target="#initiateModal" class="btn btn-primary mr-1"><i class="fas fa-sync"></i></a>
                            <a title="Supprimer" data-key="{{ $item['documentId'] }}" class="btn btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash"></i></a>
                        </td>
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

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('document.delete') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <p class="mb-0">Voulez vous vraiment supprimer ce document ?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="documentId" id="documentId" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                        <button type="submit" class="btn btn-danger">Oui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="initiateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('document.initiate') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <p class="mb-0">Voulez vous vraiment initier ce document ?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="initiateId" id="initiateId" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                        <button type="submit" class="btn btn-success">Oui</button>
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
                modal.find('#documentId').val(deleteId);
            })

            $('#initiateModal').on('show.bs.modal', function(e) {
                var button = $(e.relatedTarget);
                var initiateId = button.data('key');
                var modal = $(this);
                modal.find('#initiateId').val(initiateId);
            })
        });
    </script>
@endsection
