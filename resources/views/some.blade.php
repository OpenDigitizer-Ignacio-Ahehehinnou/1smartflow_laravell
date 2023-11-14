<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />

	<title>Inscription | Smartflow</title>

	<link href="{{asset('css/app.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.form.io/formiojs/formio.full.min.css'>
    <script src='https://cdn.form.io/formiojs/formio.full.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body style="background-color: white">

            <div class="row">
                <div class="col-sm-12">
                    <h5 class="">Créez un formulaire de type <select class="form-control" id="form-select" style="display: inline-block; width: 150px; height:2rem;">
                            <option value="form">Form</option>
                            <option value="wizard">Wizard</option>
                            <option value="pdf">PDF</option>
                        </select></h5>
                        <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
                        <div class=" mb-3">
                            <label class="form-label">Titre</label>
                            <input class="form-control form-control-lg" type="text" required="true" name="title" />
                        </div>

                    <div id="builder" class="mt-4 mr-6" style="width: 155vh;">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-8 offset-sm-2">
                        <h3 class="text-center text-muted">Rendu</h3>
                        <div id="formio" class="card card-body bg-light">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                 <div class="row mt-2">
                    <div class="col-sm-8 offset-sm-2">
                        <h3 class="text-center text-muted">Données de soumission</h3>
                        <div class="card card-body bg-light jsonviewer">
                            <pre id="subjson">

                            </pre>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                {{-- <div class="row mt-2">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-md btn-success">Enregistrer</button>
                    </div>
                </div> --}}
                <div class="col-sm-8 offset-sm-2 mt-4">
                    <h3 class="text-center text-muted">Schema Json</h3>
                    <div class="card card-body bg-light jsonviewer">
                        <pre id="json">

                        </pre>
                    </div>
                </div>
            </div>




            <script type="text/javascript">
                var jsonElement = document.getElementById('json');
                var formElement = document.getElementById('formio');
                var subJSON = document.getElementById('subjson');
                var builder = new Formio.FormBuilder(document.getElementById("builder"), {
                    display: 'form',
                    components: [{
                            type: 'textfield',
                            key: 'firstName',
                            label: 'First Name'
                        }
                    ]
                }, {
                    builder: {
                        custom: {
                            title: 'Pre-Defined Fields',
                            weight: 10,
                            components: {
                                firstName: {
                                    title: 'First Name',
                                    key: 'firstName',
                                    icon: 'terminal',
                                    schema: {
                                        label: 'First Name',
                                        type: 'textfield',
                                        key: 'firstName',
                                        input: true
                                    }
                                },
                                lastName: {
                                    title: 'Last Name',
                                    key: 'lastName',
                                    icon: 'terminal',
                                    schema: {
                                        label: 'Last Name',
                                        type: 'textfield',
                                        key: 'lastName',
                                        input: true
                                    }
                                },
                                email: {
                                    title: 'Email',
                                    key: 'email',
                                    icon: 'at',
                                    schema: {
                                        label: 'Email',
                                        type: 'email',
                                        key: 'email',
                                        input: true
                                    }
                                },
                                phoneNumber: {
                                    title: 'Mobile Phone',
                                    key: 'mobilePhone',
                                    icon: 'phone-square',
                                    schema: {
                                        label: 'Mobile Phone',
                                        type: 'phoneNumber',
                                        key: 'mobilePhone',
                                        input: true
                                    }
                                }
                            }
                        }
                    }
                });





                var onForm = function(form) {
                    form.on('change', function() {
                        subJSON.innerHTML = '';
                        subJSON.appendChild(document.createTextNode(JSON.stringify(form.submission, null, 4)));
                    });
                };

                var onBuild = function(build) {
                    jsonElement.innerHTML = '';
                    formElement.innerHTML = '';
                    jsonElement.appendChild(document.createTextNode(JSON.stringify(builder.instance.schema, null, 4)));
                    Formio.createForm(formElement, builder.instance.form).then(onForm);
                };

                var onReady = function() {
                    var jsonElement = document.getElementById('json');
                    var formElement = document.getElementById('formio');
                    builder.instance.on('change', onBuild);
                };

                var setDisplay = function(display) {
                    builder.setDisplay(display).then(onReady);
                };

                // Handle the form selection.
                var formSelect = document.getElementById('form-select');
                formSelect.addEventListener("change", function() {
                    setDisplay(this.value);
                });

                builder.instance.ready.then(onReady);
            </script>


    <script src="{{asset('js/register.js')}}"></script>
</body>

</html>
