@extends("layouts.new")
@section('content')

<h5>Nouvel utilisateur</h5>
<div class="mb-2" style="height: 0.3rem; width:4rem; background-color: #222e3c"></div>
<div class="container-form">
    @if (session()->has('error'))
    <div class="d-flex justify-content-center mb-1 mt-2">
        <div class="col-md-7">
            <div class="alert alert-danger alert-outline-coloured alert-dismissible"
                role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
                <div class="alert-icon">
                    <i class="far fa-fw fa-bell"></i>
                </div>
                <div class="alert-message">
                    <b style="font-size: 14px;">{{ Session::get('error') }}</b>
                </div>
            </div>
        </div>
    </div>
    @endif

<form id="signUpForm" method="POST" action="{{ route('user.handle.create') }}" class="form">
    @csrf
    <!-- start step indicators -->
    <div class="form-header d-flex mb-4">
        <span class="stepIndicator">Utilisateur</span>
        <span class="stepIndicator">Mot de passe</span>
    </div>
    <!-- end step indicators -->

    <!-- step one -->
    <div class="step">
        <p class="text-center mb-4">Informations sur l'utilisateur</p>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Nom</label>
                <input type="text" placeholder="" value="{{ old('lastname') }}" oninput="this.className = ''" name="lastname">
            </div>
            <div class="col mb-3">
                <label class="form-label">Prénom(s)</label>
                <input type="text" placeholder="" value="{{ old('firstname') }}" oninput="this.className = ''"  name="firstname">
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Téléphone</label>
                <input type="text" placeholder="" value="{{ old('phone') }}" oninput="this.className = ''" name="phone">
            </div>
            <div class="col mb-3">
                <label class="form-label">Email</label>
                <input type="email" placeholder="" value="{{ old('email') }}" oninput="this.className = ''"  name="email">
            </div>
             @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
        </div>
        <div class="row">
        <div class="col mb-3">
            <label class="form-label">Fonction</label>
            <select name="functionId" class="form-control mb-3" name="functionId">
                <option selected>Choisir une fonction</option>
                @foreach ($functions as $item)
                <option value="{{ $item['functionId'] }}"  @if(old('functionId') === $item['functionId']) selected @endif>{{ $item['libelle'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-3">
            <label class="form-label">Rôle</label>
            <select class="form-control mb-3" name="roleId">
                <option selected>Choisir un rôle</option>
                @foreach ($roles as $item)
                <option value="{{ $item['roleId'] }}">{{ $item['label'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    </div>

    <!-- step two -->
    <div class="step">
        <p class="text-center mb-4">Définissez un mot de passe</p>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input id="password" type="password"  placeholder="Entrez votre mot de passe" oninput="this.className = ''" name="password">
        </div>
        <div class="mb-2">
            <label class="form-label">Confirmez le mot de passe</label>
            <input id="confirm_password" type="password" placeholder="Confirmer le mot de passe" oninput="this.className = ''" name="confirm">
        </div>
        <div class="validator-criters mb-1">
            <span class="chiffre" style="margin-bottom: 2px"><i class="far fa-check-circle"></i> &nbsp;Votre
                mot de passe doit comporter au minimum 1 chiffres</span>
            <span class="majuscule" style="margin-bottom: 2px"><i class="far fa-check-circle"></i>
                &nbsp;Votre mot de passe doit comporter au minimum 1 lettre
                majuscule</span>
            <span class="minuscule" style="margin-bottom: 2px"><i class="far fa-check-circle"></i>
                &nbsp;Votre mot de passe doit comporter au minimum 1 lettre
                minuscule</span>
                <span class="speciaux" style="margin-bottom: 2px"><i class="far fa-check-circle"></i>
                    &nbsp;Votre mot de passe doit comporter au minimum 1 caractère
                    spécial</span>
            <span class="generique" style="margin-bottom: 2px"><i class="far fa-check-circle"></i>
                &nbsp;Votre mot de passe doit comporter au minimum 8
                caractères</span>
        </div>
    </div>

    <!-- start previous / next buttons -->
    <div class="form-footer d-flex">
        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
        <button type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
    </div>
    <!-- end previous / next buttons -->
</form>
</div>
<style>
    #signUpForm {
        max-width: 700px;
        background-color: #ffffff;
        margin: 40px auto;
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
    #signUpForm .form-footer{
        overflow:auto;
        gap: 20px;
    }
    #signUpForm .form-footer button{
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
    const submit = document.getElementById('nextBtn');
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
                document.getElementById("nextBtn").innerHTML = "Enregistrer";
                document.getElementById("nextBtn").type = "submit";
              } else {
                document.getElementById("nextBtn").innerHTML = "Suivant";
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
                // ... the form gets submitted:
                document.getElementById("signUpForm").submit();
                return false;
              }
              // Otherwise, display the correct tab:
              showTab(currentTab);
            }

            function validateForm() {
              // This function deals with validation of the form fields
              var x, y, i, valid = true;
              x = document.getElementsByClassName("step");
              y = x[currentTab].getElementsByTagName("input");
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

            submit.addEventListener('click', function(e) {
            e.preventDefault;

            if(submit.innerHTML === "Enregistrer"){
                console.log("Je marche bien bon");
            }
            });

            $("#signUpForm").on('submit', (e) => {
                e.preventDefault();
            });


      </script>

@endsection
