@extends('layouts.form')
@section('content')
    <input id="content" type="hidden" name="content" value="{{ $form['content'] }}">
    <input id="code" type="hidden" name="code" value="{{ $form['code'] }}">
    <input id="deletedFlag" type="hidden" name="deletedFlag" value="{{ $form['deletedFlag'] }}">
    <input id="status" type="hidden" name="status" value="{{ $form['status'] }}">
    <input id="userIdForLog" type="hidden" name="userIdForLog" value="{{ $form['userIdForLog'] }}">
    <input id="agreeLevelNumber" type="hidden" name="agreeLevelNumber" value="{{ $form['agreeLevelNumber'] }}">
    <input id="createdBy" type="hidden" name="createdBy" value="{{ $form['createdBy'] }}">
    <input id="createdAt" type="hidden" name="createdAt" value="{{ $form['createdAt'] }}">
    <input id="formId" type="hidden" name="formId" value="{{ $form['formId'] }}">

    <div class="back">
        <form id="signUpForm" enctype="multipart/form-data" class="form">
            @csrf
            <!-- start step indicators -->
            <div class="form-header d-flex mb-4">
                <span class="stepIndicator">Formulaire</span>
                <span class="stepIndicator">Apercu</span>
            </div>
            <!-- end step indicators -->

            <!-- step one -->
            <div class="step">
                <div class="row">
                    <div class="col-sm-12" style="overflow: auto;">
                        <h5>Modifier le formulaire de type <select class="form-control" id="form-select"
                                style="display: inline-block; width: 150px; height:2rem;">
                                <option value="form">Form</option>
                                <option value="wizard">Wizard</option>
                                <option value="pdf">PDF</option>
                            </select></h5>
                        <div class="mb-2"
                            style="height: 0.3rem; width:4rem; background-color: #222e3c; margin-top: -0.3rem"></div>
                        <div class=" mb-3">
                            <label class="form-label">Titre</label>
                            <input id="new_title" class="form-control form-control-lg class" type="text" required="true"
                                name="new_title" value="{{ $form['name'] }}" />
                        </div>

                        <div id="builder" class="mt-4 mr-6" style="width: 155vh;">
                        </div>
                    </div>


                    <div class="col-sm-8 offset-sm-2 mt-4 hidden">
                        <h3 class="text-center text-muted">Schema Json</h3>
                        <div class="card card-body bg-light jsonviewer">
                            <pre id="json">

                    </pre>
                        </div>
                    </div>
                </div>
                <input id="title_update" type="hidden" name="title" value="">
                <input id="content_update" type="hidden" name="content" value="">
            </div>

            <!-- step two -->
            <div class="step">
                <h5>Apercu</h5>
                <div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
                <div class="row mt-2">
                    <div class="col-sm-8 offset-sm-2">
                        <div id="formio" class="card card-body bg-light">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <!-- start previous / next buttons -->
            <div class="form-footer d-flex">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
                <button type="button" id="nextBtn" class="enregistrer-button" onclick="nextPrev(1)">Suivant</button>
            </div>
            <!-- end previous / next buttons -->
        </form>
    </div>

    <style>
        #signUpForm {
            width: 1150px;
            background-color: #ffffff;
            margin: 30px auto;
            padding: 40px;
            box-shadow: 0px 6px 18px rgb(0 0 0 / 9%);
            border-radius: 12px;
        }

        #signUpForm .form-header {
            gap: 5px;
            text-align: center;
            font-size: 12px;
        }

        #signUpForm .form-header .stepIndicator {
            position: relative;
            flex: 1;
            padding-bottom: 30px;
        }

        #signUpForm .form-header .stepIndicator.active {
            font-weight: 600;
        }

        #signUpForm .form-header .stepIndicator.finish {
            font-weight: 600;
            color: #144194;
        }

        #signUpForm .form-header .stepIndicator::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            z-index: 9;
            width: 20px;
            height: 20px;
            background-color: #d5efed;
            border-radius: 50%;
            border: 3px solid #ecf5f4;
        }

        #signUpForm .form-header .stepIndicator.active::before {
            background-color: #0d6efd;
            border: 3px solid #89cfff;
        }

        #signUpForm .form-header .stepIndicator.finish::before {
            background-color: #0c5ae9;
            border: 3px solid #0d6efd;
        }

        #signUpForm .form-header .stepIndicator::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 8px;
            width: 100%;
            height: 3px;
            background-color: #f3f3f3;
        }

        #signUpForm .form-header .stepIndicator.active::after {
            background-color: #89cfff;
        }

        #signUpForm .form-header .stepIndicator.finish::after {
            background-color: #0c5ae9;
        }

        #signUpForm .form-header .stepIndicator:last-child:after {
            display: none;
        }

        #signUpForm input {
            padding: 10px 15px;
            width: 100%;
            font-size: 1em;
            border: 1px solid #e3e3e3;
            border-radius: 5px;
        }

        #signUpForm input:focus {
            border: 1px solid #0d6efd;
            outline: 0;
        }

        #signUpForm input.invalid {
            border: 1px solid #dc3545;
        }

        #signUpForm .step {
            display: none;
        }

        #signUpForm .form-footer {
            overflow: auto;
            gap: 20px;
        }

        #signUpForm .form-footer button {
            background-color: #0d6efd;
            border: 1px solid #0d6efd !important;
            color: #ffffff;
            border: none;
            padding: 13px 30px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            margin-top: 5px;
        }

        #signUpForm .form-footer button:hover {
            opacity: 0.8;
        }

        #signUpForm .form-footer #prevBtn {
            background-color: #fff;
            color: #0d6efd;
        }
    </style>


    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("step");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                console.log(n);
                document.getElementById("nextBtn").innerHTML = "Enregistrer";
                // var ajaxExecuted = false; // Drapeau pour vérifier si la requête AJAX a été exécutée

            } else {
                document.getElementById("nextBtn").innerHTML = "Suivant";
            }


            // console.log(n);
            if (n == 2) {

            }

            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }


        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("step");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // document.getElementById("signUpForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("step");
            y = x[currentTab].getElementsByClassName("class");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("stepIndicator")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("stepIndicator");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>



    <script type="text/javascript">
        var content = $('#content').val();
        const formed = JSON.parse(content);
        var jsonElement = document.getElementById('json');
        var formElement = document.getElementById('formio');
        var subJSON = document.getElementById('subjson');
        let compteurs = {};


        let agreeLevelNumber = 0;
        var builder = new Formio.FormBuilder(document.getElementById("builder"), formed, {
            builder: {

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

    <script>
        //Send the data to the controller
        $(document).ready(function() {

            $('#nextBtn').on('click', function() {
                if ($(this).html() === 'Enregistrer') {
                    var save = document.getElementById('nextBtn');
                    save.addEventListener('click', function() {
                        var formId = $('#formId').val();
                        var title = $('#new_title').val();
                        var code = $('#code').val();
                        var status = $('#status').val();
                        var userIdForLog = $('#userIdForLog').val();
                        var agreeLevelNumber = $('#agreeLevelNumber').val();
                        var createdBy = $('#createdBy').val();
                        var createdAt = $('#createdAt').val();
                        var deletedFlag = $('#deletedFlag').val();
                        var smartJson = document.getElementById('json').innerHTML;
                        save.disabled = true;
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "http://127.0.0.1:8000/form/update",
                            type: "POST",
                            data: {
                                formId: formId,
                                title: title,
                                content: smartJson,
                                code: code,
                                status: status,
                                userIdForLog: userIdForLog,
                                agreeLevelNumber: agreeLevelNumber,
                                createdBy: createdBy,
                                createdAt: createdAt,
                                deletedFlag: deletedFlag,
                            },
                            success: function(data) {
                                window.location =
                                    "http://127.0.0.1:8000/form/myforms/0";
                            }
                        });
                    });


                }
            });
        });
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
@endsection
