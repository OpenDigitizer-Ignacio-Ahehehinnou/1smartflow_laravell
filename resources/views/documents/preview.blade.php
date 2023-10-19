@extends('layouts.master')
@section('content')
    <input id="content" name="content" type="hidden" value="{{ $form['content'] }}" />
    <input id="title" name="title" type="hidden" value="{{ $form['name'] }}" />
    <input id="submit" name="title" type="hidden" value="{{ $document['content'] }}" />
    <input id="enterprise_mail" name="enterprise_mail" type="hidden"
        value="{{ session('session.userDto.smartflowEnterprise.email') }}" />
    <div class="d-flex justify-content-between mb-3">
        <div>
            <h5>Apercu</h5>
            <div style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
        </div>
        <a href="{{ route('documents.pdf', $document['documentId']) }}"
            class="btn btn-success btn-sm">Telecharger <b>PDF</b></a>
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

                        </div>
                    </div>

                    <hr class="my-4" />

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="text-muted">Document de:</div>
                            <strong>
                                {{ $document['documentCreatorDTO']['firstName'] }}
                                {{ $document['documentCreatorDTO']['lastName'] }}
                            </strong>
                            <p>
                                {{ $document['documentCreatorDTO']['telephone'] }} <br>
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
                    <div class="row">
                        <p>Lu et approuvé par:</p>
                        @foreach ($approvals as $item)
                            <div class="col">
                                <img id="signature" width="150px" src="{{ $item['documentAgreementSignature'] }}"
                                    alt="Signature">
                                <input type="hidden" value="{{ $item['documentAgreementSignature'] }}" />
                                <h6>{{ $item['validatorFirstName'] }} {{ $item['validatorLastName'] }}</h6>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <p class="text-sm">
                            <strong>Email:</strong>
                            {{ session('session.userDto.smartflowEnterprise.email') }}
                            <strong>Crée le:</strong>
                            {{ \Carbon\Carbon::createFromTimestampMs($document['createdAt'])->format('d-m-Y H:i:s') }}
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


            //Display the signature
        });
    </script>
@endsection
