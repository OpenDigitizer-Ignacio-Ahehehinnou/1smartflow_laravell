
        let form = document.querySelector(".form");
        let input = form.password;
        let chiffre = document.querySelector(".chiffre");
        let majuscule = document.querySelector(".majuscule");
        let minuscule = document.querySelector(".minuscule");
        let generique = document.querySelector(".generique");
        let speciaux = document.querySelector(".speciaux");
        const submitBtn = document.getElementById('nextBtn');
        var password = document.getElementById('password');
        var password2 = document.getElementById('confirm_password');

        input.addEventListener("input", function() {
            validation(this);

            if (!this.value) {
                remove();
            }
        })

        function validation(password) {


            if (/[0-9]{1}/.test(password.value)) {

                input.classList.remove("invalide");
                chiffre.classList.remove("error");

                input.classList.add("succes");
                chiffre.classList.add("succes");

            } else {
                input.classList.remove("succes");
                chiffre.classList.remove("succes");

                input.classList.add("invalide");
                chiffre.classList.add("error");
            }

            if (/[A-Z]{1}/.test(password.value)) {

                input.classList.remove("invalide");
                majuscule.classList.remove("error");

                input.classList.add("succes");
                majuscule.classList.add("succes")
            } else {
                input.classList.remove("succes");
                majuscule.classList.remove("succes");

                input.classList.add("invalide");
                majuscule.classList.add("error");
            }

            if (/[a-z]{1}/.test(password.value)) {

                input.classList.remove("invalide");
                minuscule.classList.remove("error");

                input.classList.add("succes");
                minuscule.classList.add("succes")

            } else {
                input.classList.remove("succes");
                minuscule.classList.remove("succes");

                input.classList.add("invalide");
                minuscule.classList.add("error");
            }

            if (/[!@#$%^&*()"'_+{}:;<>,.?~-]{1}/.test(password.value)) {

                input.classList.remove("invalide");
                speciaux.classList.remove("error");

                input.classList.add("succes");
                speciaux.classList.add("succes");

            } else {
                input.classList.remove("succes");
                speciaux.classList.remove("succes");

                input.classList.add("invalide");
                speciaux.classList.add("error");
            }


            if (password.value.length >= 8) {

                generique.classList.remove("error");
                generique.classList.add("succes");

            } else {
                generique.classList.add("error");
                generique.classList.remove("succes");
            }

            // Vérification des conditions de mot de passe
            if (/[0-9]{1}/.test(password.value) &&
                /[A-Z]{1}/.test(password.value) &&
                /[a-z]{1}/.test(password.value) &&
                /[!@#$%^&*()"'_+{}:;<>,.?~-]{1}/.test(password.value) &&
                password.value.length >= 8 && submitBtn.innerHTML === "Enregistrer") {
                // Toutes les conditions sont remplies, activez le bouton
                submitBtn.disabled = false;
            } else {
                // Au moins une condition n'est pas remplie, laissez le bouton désactivé
                submitBtn.disabled = true;

            }

        }

        function remove() {

            input.classList.remove("invalide");
            input.classList.remove("succes");

            chiffre.classList.remove("error");
            chiffre.classList.remove("succes");

            majuscule.classList.remove("succes");
            majuscule.classList.remove("error");

            minuscule.classList.remove("succes");
            minuscule.classList.remove("error")

            generique.classList.remove("succes")
            generique.classList.remove("error");

            speciaux.classList.remove("succes")
            speciaux.classList.remove("error");
        }

