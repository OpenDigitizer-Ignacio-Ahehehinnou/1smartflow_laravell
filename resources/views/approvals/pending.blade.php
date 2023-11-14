@extends('layouts.approvlay')
@section('content')

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

    <div class="mb-3">
        <h5>Documents en attente</h5>
        <div style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    </div>
    <div class="card mt-2" style="padding: 1.5rem">
        <table class="table table-striped" style="width:100%">
            <div class="d-flex justify-content-end">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <form method="POST" action="{{ route('approval.search')}}" >
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
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pending as $item)
                    <tr>

                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['createdBy'] }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimestampMs($item['createdAt'])->format('d-m-Y H:i:s') }}</td>
                        <td><a title="Consulter" href="{{route('document.display', ['documentId' => $item['documentId']])}}" class="btn btn-primary mr-1"><i
                                    class="fas fa-eye"></i></a>
                            <a title="Signer" data-key="{{ $item['documentId'] }}" data-level="{{ $item['actualAgreeLevel'] }}" class="btn btn-info mr-1" data-bs-toggle="modal"
                                data-bs-target="#signModal"><i class="fas fa-pen-alt"></i></a>
                                @if(session('session.userDto.signature') !== null)
                            <a title="Valider" data-key="{{ $item['documentId'] }}" data-level="{{ $item['actualAgreeLevel'] }}" class="btn btn-success mr-1" data-bs-toggle="modal"
                                data-bs-target="#validModal"><i class="fas fa-check-circle"></i></a>
                                @endif
                            <a title="Rejeter" data-key="{{ $item['documentId'] }}" data-level="{{ $item['actualAgreeLevel'] }}" class="btn btn-danger"
                                data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fas fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-1" style="margin-top: 0.5rem;">
            @if($numberOfElements == 0)
                <p>Pas d'éléments</p>
                <hr>
                @endif
        </div>
        <div class="d-flex justify-content-between mt-2">
            <div class="">

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

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('approval.reject') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <p class="mb-0">Voulez vous vraiment rejeter ce document ?</p>
                        <hr style="background-color: #222e3c">
                        <div class="mb-1 mt-2">
                            <label for="comment" class="form-label"><b>Motif du rejet</b></label>
                            <textarea type="text" rows="4" class="form-control" id="comment" name="comment"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="rejectId" id="rejectId" value="">
                        <input type="hidden" name="level" id="level" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                        <button id="reject" type="submit" class="btn btn-danger">Oui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('approval.sign') }}">
                    @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3 ">
                    <div class="d-flex justify-content-center">
                    <canvas id="signature-canvas" class="signature-container"
                    style="border: 1px solid #0d6efd; border-radius: 8px;"
                    width="400" height="175"></canvas>
                    </div>
                    <div class="mt-2">
                    <a id="clear" class="btn btn-danger btn-sm" style="color: #fff">Effacer
                    </a>
                    </div>
                    <input id="signature" type="hidden" name="signature" value=""/>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="signId" id="signId" value="">
                    <input type="hidden" name="level" id="level" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                    <button id="save" type="submit" class="btn btn-success">Oui</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="validModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('approval.valid') }}">
                    @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-3">
                    <p>Voulez vous vraiment valider ce document?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="validId" id="validId" value="">
                    <input type="hidden" name="level" id="level" value="">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                    <button id="valid" type="submit" class="btn btn-success">Oui</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {

        $('#rejectModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var rejectId = button.data('key');
            var level = button.data('level');
            var modal = $(this);
            modal.find('#rejectId').val(rejectId);
            modal.find('#level').val(level);
        });

        $('#signModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var signId = button.data('key');
            var level = button.data('level');
            var modal = $(this);
            modal.find('#signId').val(signId);
            modal.find('#level').val(level);
        });

        $('#validModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var validId = button.data('key');
            var level = button.data('level');
            var modal = $(this);
            modal.find('#validId').val(validId);
            modal.find('#level').val(level);
        });
    });
    </script>

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

        $('#clear').on('click', function() {
            context.clearRect(0, 0, canvas.width, canvas.height);
        });

        $('#save').on('click', function() {
            const signatureDataURL = canvas.toDataURL();
            const signatureInput = document.getElementById('signature');
            signatureInput.value = signatureDataURL;
        });
    });
</script>
@endsection
