@extends('layouts.master')
@section('content')
<input id="content" name="content" type="hidden" value="{{ $form['content'] }}" />
<input id="title" name="title" type="hidden" value="{{ $form['name'] }}" />
<input id="submit" name="title" type="hidden" value="{{ $document['content'] }}" />
<input id="enterprise_mail" name="enterprise_mail" type="hidden" value="{{ session('session.userDto.smartflowEnterprise.email') }}"/>
    <div class="d-flex justify-content-between mb-3">
        <div>
            <h5>Apercu</h5>
            <div style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
    <div class="card" style="width: 21cm;">
         <div class="card-body">
            <h6>Rejeté par:</h6>
            <p>{{ $document['rejecteDocumentAgreementDTO']['validatorLastName'] }} {{ $document['rejecteDocumentAgreementDTO']['validatorFirstName'] }}</p>
            <h6 style="color: red">Motif du rejet</h6>
            <p>{{ $document['rejecteDocumentAgreementDTO']['comment'] }}</p>
        </div>
    </div>
    </div>
    <div class="row ">

        <div class="d-flex justify-content-center">
            <div class="card" style="width: 21cm;">
                <div class="card-body m-sm-3 m-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-muted">Code doc:</div>
                            <strong>{{ $document['code'] }}</strong>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="text-muted">Date de création</div>
                            <strong>{{ \Carbon\Carbon::createFromTimestampMs($document['createdAt'])->format('d-m-Y H:i:s') }}</strong>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="text-muted">Document de:</div>
                            <strong>
                                {{ $document['documentCreatorDTO']['lastName'] }}  {{ $document['documentCreatorDTO']['firstName'] }}
                            </strong>
                            <p>
                                {{ $document['documentCreatorDTO']['telephone'] }}  <br>
                                <a href="#">
                                    {{ $document['documentCreatorDTO']['username'] }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="text-muted">Entreprise</div>
                            <strong>
                                {{ session('session.userDto.smartflowEnterprise.name') }}
                            </strong>
                            <p>
                                {{ session('session.userDto.smartflowEnterprise.ifu') }}<br>
                                <a href="#">
                                    {{ session('session.userDto.smartflowEnterprise.email') }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div id="formio"></div>
                    <hr class="my-4" />
                    <div class="text-center">
                        <p class="text-sm">
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
         var content = $('#content').val();
         var submit = $('#submit').val();
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

         });
    </script>
@endsection
