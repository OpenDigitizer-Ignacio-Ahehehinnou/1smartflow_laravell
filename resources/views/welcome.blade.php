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

</head>

<body style="background-color: white">

    <h1 class="text-center fs-4 mt-5">Form Wizard - Multi Step Form</h1>
    <form id="signUpForm" action="#!">
        <!-- start step indicators -->
        <div class="form-header d-flex mb-4">
            <span class="stepIndicator">Account Setup</span>
            <span class="stepIndicator">Social Profiles</span>
            <span class="stepIndicator">Personal Details</span>
            <span class="stepIndicator">One more</span>
        </div>
        <!-- end step indicators -->

        <!-- step one -->
        <div class="step">
            <p class="text-center mb-4">Create your account</p>
            <div class="row">
                <div class="col mb-3">
                    <input type="email" placeholder="Email Address" oninput="this.className = ''" name="email">
                </div>
                <div class="col mb-3">
                    <input type="password" placeholder="Password" oninput="this.className = ''" name="password">
                </div>
            </div>

            <div class="mb-3">
                <input type="password" placeholder="Confirm Password" oninput="this.className = ''" name="password">
            </div>
        </div>

        <!-- step two -->
        <div class="step">
            <p class="text-center mb-4">Your presence on the social network</p>
            <div class="mb-3">
                <input type="text" placeholder="Linked In" oninput="this.className = ''" name="linkedin">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Twitter" oninput="this.className = ''" name="twitter">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Facebook" oninput="this.className = ''" name="facebook">
            </div>
        </div>

        <!-- step three -->
        <div class="step">
            <p class="text-center mb-4">We will never sell it</p>
            <div class="mb-3">
                <input type="text" placeholder="Full name" oninput="this.className = ''" name="fullname">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Mobile" oninput="this.className = ''" name="mobile">
            </div>
            <div class="mb-3">
                <input type="text" placeholder="Address" oninput="this.className = ''" name="address">
            </div>
        </div>

        <!-- start previous / next buttons -->
        <div class="form-footer d-flex">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
        <!-- end previous / next buttons -->
    </form>


 
</body>

</html>
