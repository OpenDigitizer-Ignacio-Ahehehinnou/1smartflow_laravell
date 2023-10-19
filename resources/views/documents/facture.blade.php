<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>Smartflow</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel='stylesheet' href='https://cdn.form.io/formiojs/formio.full.min.css'>
    <script src='https://cdn.form.io/formiojs/formio.full.min.js'></script>



    <style>
        body {
            font-family: sans-serif;
        }

        .box-container {
            width: 80%;
            padding: 2rem;
            border: 1px solid #f2f2f2;
            border-radius: 5px;
            background-color: #ffffff;
            margin-left: 10%;
            margin-right: 10%;
        }

        .box-container .title {
            font-weight: bold;
            padding: 1rem;
            border-bottom: 1px solid #f2f2f2;
            background-color: #f2f2f2;
        }

        .transaction-box {
            margin-top: 1rem;
        }

        .transaction-box .item {
            display: table;
            width: 100%;
            margin-bottom: 1rem;
        }

        .transaction-box .item>* {
            display: table-cell;
            vertical-align: middle;
        }

        .transaction-box .item> :first-child {
            text-align-last: left;
        }

        .transaction-box .item> :last-child {
            text-align-last: right;
            font-weight: bold;
        }

        .transaction_details_box {
            margin-top: 3rem;
            border-radius: 5px;
            display: table;
            width: 100%;
            margin-bottom: 3rem;
        }

        .transaction_details_box .left {
            display: table;
            margin-bottom: 1rem;
            width: 100%;
        }

        .transaction_details_box .left>* {
            display: table-cell;
            vertical-align: middle;
        }



        .transaction_details_box .left .item {
            display: table;
            width: 100%;
            float: left;
            margin-bottom: 1rem;
        }

        .transaction_details_box .left .item>* {
            display: table-cell;
            vertical-align: middle;

            width: 100%;
            margin-bottom: 1rem;
        }

        .transaction_details_box .left .item> :first-child {
            text-align: left;
        }

        .transaction_details_box .left .item> :last-child {
            text-align: right;
        }

        .transaction_details_box .right {
            display: table;
            width: 100%;
        }

        .transaction_details_box .right table {
            width: 100%;
        }

        .transaction_details_box .right .payment_tile {
            margin-top: 2rem;
            margin-bottom: 2rem;
            text-transform: uppercase;
            font-weight: bold;
        }

        th {
            background: #8a97a0;
            color: #fff;
        }

        tr {
            background: #f4f7f8;
        }

        tr:nth-child(even) {
            background: #e8eeef;
        }

        th,
        td {
            padding: 0.5rem;
        }

        .single_item .value {
            font-weight: bold;
        }
    </style>



</head>

<body>

    <input id="content2" name="content" type="hidden" value="{{ $form['content'] }}" />
    <input id="title" name="title" type="hidden" value="{{ $form['name'] }}" />
    <input id="submit2" name="title" type="hidden" value="{{ $resp['content'] }}" />
    <input id="enterprise_mail" name="enterprise_mail" type="hidden"
        value="{{ session('session.userDto.smartflowEnterprise.email') }}" />


    <div class="row">
        <div class="">
            <div class="card" style="width: 20cm;">
                <div class="card-body m-sm-3 m-md-5">

                    <div>
                        <span style="float: left; margin-right: 0px;">
                            <div class="text-muted">Code doc:</div>
                            <strong>{{ $resp['code'] }}</strong>
                        </span>
                        <span style="float: right; margin-left: 50px;">
                            <h4>Date de création</h4>
                            <p>{{ \Carbon\Carbon::createFromTimestampMs($resp['createdAt'])->format('d-m-Y H:i:s') }}
                            </p>
                        </span>
                    </div>



                    <br><br><br><br><br>

                    <div>
                        <hr />
                        <span style="float: left;margin-right: 10px;">
                            <h4 class="text-muted">Document de:</h4>
                            <p>
                                {{ $resp['documentCreatorDTO']['lastName'] }}
                                {{ $resp['documentCreatorDTO']['firstName'] }}
                            </p>
                            <p>
                                {{ $resp['documentCreatorDTO']['telephone'] }} <br>
                                <a href="#">
                                    {{ $resp['documentCreatorDTO']['username'] }}
                                </a>
                            </p>
                        </span>
                        <span style="float: right;margin-left: 10px;"">
                            <h4 class="text-muted">Entreprise</h4>
                            <h5>
                                {{ session('session.userDto.smartflowEnterprise.name') }}
                            </h5>
                            <p>
                                {{ session('session.userDto.smartflowEnterprise.ifu') }}<br>
                                <a href="#">
                                    {{ session('session.userDto.smartflowEnterprise.email') }}
                                </a>
                            </p>
                        </span>
                    </div>

                    <div id="formio"></div>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <div class="row">
                        <h6>Lu et approuvé par:</h6>
                        {{-- @foreach ($resp as $item) --}}
                        <div class="col">

                            <img id="signature" width="150px"
                                src="{{ $resp['listOfSmartflowDocumentSuccessAgreement'][0]['documentAgreementSignature'] }}"
                                alt="Signature">
                            <input type="hidden"
                                value="{{ $resp['listOfSmartflowDocumentSuccessAgreement'][0]['documentAgreementSignature'] }}" />
                            <h6>{{ $resp1 }} {{ $resp2 }}</h6>

                        </div>
                        {{-- @endforeach --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <hr />
    <script>
        var content = $('#content2').val();
        var submit = $('#submit2').val();

        alert(content);
        //console.log(content);
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


</body>

</html>
