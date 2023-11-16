@extends('layouts.lay')
@section('content')
    <input id="content" name="content" type="hidden" value="{{ $form['content'] }}" />
    <input id="documentId" name="documentId" type="hidden" value="{{ $document['documentId'] }}" />
    <input id="submit" name="submit" type="hidden" value="{{ $document['content'] }}" />
    <input id="name" name="name" type="hidden" value="{{ $document['name'] }}" />
    <input id="formId" name="formId" type="hidden" value="{{ $document['formId'] }}" />
    <input id="createdBy" name="createdBy" type="hidden" value="{{ $document['createdBy'] }}" />
    <input id="submit" name="title" type="hidden" value="{{ $document['createdAt'] }}" />
    <input id="deletedFlag" name="deletedFlag" type="hidden" value="{{ $document['deletedFlag'] }}" />
    <input id="status" name="status" type="hidden" value="{{ $document['status'] }}" />
    <input id="agreeLevelNumber" name="agreeLevelNumber" type="hidden" value="{{ $document['agreeLevelNumber'] }}" />
    <input id="actualAgreeLevel" name="actualAgreeLevel" type="hidden" value="{{ $document['actualAgreeLevel'] }}" />
    <input id="userIdForLog" name="userIdForLog" type="hidden" value="{{ $document['userIdForLog'] }}" />
    <input id="code" name="code" type="hidden" value="{{ $document['code'] }}" />

    <h5>Modifier le document</h5>
    <div class="mb-4" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
    <div class="card">
        <div class="card-body">
            <h6>Rejeté par:</h6>
            <p>{{ $document['rejecteDocumentAgreementDTO']['validatorLastName'] }}
                {{ $document['rejecteDocumentAgreementDTO']['validatorFirstName'] }}</p>
            <h6 style="color: red">Motif du rejet</h6>
            <p>{{ $document['rejecteDocumentAgreementDTO']['comment'] }}</p>
        </div>
    </div>

    <div class="card mt-2" style="padding: 2rem;">
        <form id="editForm" action="{{ route('document.update') }}" method="post">
            @csrf
            <h5>{{ $form['name'] }}</h5>
            <div id="formio"></div>
            <div class="d-flex justify-content-end">
                <button id="enregistrer" type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>

    </div>

    <script>
        var content = $('#content').val();
        var submit = $('#submit').val();
        var documentId = $('#documentId').val();
        var name = $('#name').val();
        var formId = $('#formId').val();
        var createdBy = $('#createdBy').val();
        var createdAt = $('#createdAt').val();
        var deletedFlag = $('#deletedFlag').val();
        var status = $('#status').val();
        var agreeLevelNumber = $('#agreeLevelNumber').val();
        var actualAgreeLevel = $('#actualAgreeLevel').val();
        var userIdForLog = $('#userIdForLog').val();
        var code = $('#code').val();
        let data = {};
        $(() => {
            var form = JSON.parse(content);
            var formData = JSON.parse(submit);
            $(document).ready(function() {
                Formio.createForm(document.getElementById('formio'), form).then(function(form) {
                    // Prevent the submission from going to the form.io server.
                    form.readOnly = true;
                    form.submission = {
                        data: formData,
                    };
                    form.nosubmit = true;
                    form.on('submit', function(submission) {
                        data = submission;
                    });
                });
            });

            $("#editForm").on('submit', (e) => {
                e.preventDefault();
                console.log("Testttttt");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                $.ajax({
                    url: "http://127.0.0.1:8000/document/update",
                    type: "POST",
                    data: {
                        documentId: documentId,
                        content: JSON.stringify(data['data']),
                        name: name,
                        formId: formId,
                        createdBy: createdBy,
                        createdAt: createdAt,
                        deletedFlag: deletedFlag,
                        status: status,
                        agreeLevelNumber: agreeLevelNumber,
                        actualAgreeLevel: actualAgreeLevel,
                        code: code,
                        userIdForLog: userIdForLog,

                    },
                    success: function(data) {
                        window.location = "http://127.0.0.1:8000/document/rejected?page=0";
                    }
                });
            });

        });
    </script>

    <script></script>
@endsection
