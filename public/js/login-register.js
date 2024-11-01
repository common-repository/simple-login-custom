document.addEventListener('DOMContentLoaded', function() {
    const loginSwitchBtn = document.getElementById('switch-login-btn');
    const registerSwitchBtn = document.getElementById('switch-register-btn');
    
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    if (loginSwitchBtn && registerSwitchBtn && loginForm && registerForm) {
        loginSwitchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        });

        registerSwitchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });
    }

    /**
     * Vérifie et soumet les formulaires de login et register via AJAX.
     * @param {string} formId - L'ID du formulaire à vérifier.
     * @param {string} errorId - L'ID de l'élément pour afficher les erreurs.
     * @param {string} successId - L'ID de l'élément pour afficher les messages de succès.
     */
    function validateForm(formId, errorId, successId) {
        const form = document.getElementById(formId);
        const errorMessage = document.getElementById(errorId);
        const successMessage = document.getElementById(successId);

        if (!form) return;

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche la soumission par défaut du formulaire

            const inputs = form.querySelectorAll('input[required]');
            const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
            const password = document.getElementById('user_pass');
            const confirmPassword = document.getElementById('user_pass_confirm');
            
            if (!allFilled || (password && confirmPassword && password.value !== confirmPassword.value)) {
                errorMessage.innerHTML = '';
                
                if (!allFilled) {
                    Array.from(inputs).filter(input => input.value.trim() === '').forEach(field => {
                        const label = document.querySelector(`label[for="${field.id}"]`);
                        const fieldName = label ? label.textContent : field.name;
                        errorMessage.innerHTML += `<p>Le champ ${fieldName} est requis.</p>`;
                    });
                }
                
                if (password && confirmPassword && password.value !== confirmPassword.value) {
                    errorMessage.innerHTML += '<p>Les mots de passe ne correspondent pas.</p>';
                }
                
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
            } else {
                const formData = new FormData(form);
                formData.append('action', 'custom_register'); // Ajouter l'action AJAX
                formData.append('nonce', ajax_object.nonce);   // Ajouter le nonce

                fetch(ajax_object.ajax_url, { // Utiliser l'URL AJAX localisée
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin' // Inclure les cookies
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        errorMessage.style.display = 'none';
                        successMessage.innerHTML = data.data.message;
                        successMessage.style.display = 'block';
                        form.reset(); // Réinitialiser le formulaire après une inscription réussie
                    } else {
                        errorMessage.innerHTML = data.data.message;
                        errorMessage.style.display = 'block';
                        successMessage.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMessage.innerHTML = 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.';
                    errorMessage.style.display = 'block';
                    successMessage.style.display = 'none';
                });
            }
        });
    }
	
	 /**
     * Vérifie les champs d'un formulaire de connexion et affiche les messages d'erreur ou de succès.
     * @param {string} formId - L'ID du formulaire à vérifier.
     * @param {string} errorId - L'ID de l'élément pour afficher les erreurs.
     * @param {string} successId - L'ID de l'élément pour afficher les messages de succès.
     */
    function validateLoginForm(formId, errorId, successId) {
        const form = document.getElementById(formId);
        const errorMessage = document.getElementById(errorId);
        const successMessage = document.getElementById(successId);

        if (!form) return;

        form.addEventListener('submit', function(event) {
            // event.preventDefault(); // Empêche la soumission par défaut du formulaire

            //const inputs = form.querySelectorAll('input');
            const usernameInput = document.querySelector('#user');
    const passwordInput = document.querySelector('#pass');

    // Création d'un tableau d'éléments comme si c'était le résultat de querySelectorAll
    const inputs = [usernameInput, passwordInput].filter(Boolean); // filter(Boolean) pour éliminer les valeurs null si un élément n'est pas trouvé

            let allFilled = true;
            errorMessage.innerHTML = ''; // Réinitialiser les messages d'erreur

            // Vérifie si tous les champs requis sont remplis
            inputs.forEach(input => {
				console.log("aklo");
				console.log(input);
                if (input.value.trim() === '') {
                    allFilled = false;
                    const label = document.querySelector(`label[for="${input.id}"]`);
                    const fieldName = label ? label.textContent : input.name;
                    errorMessage.innerHTML += `<p>Le champ ${fieldName} est requis.</p>`;
                }
            });

            // Afficher les messages d'erreur si nécessaire
            if (!allFilled) {
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
            } else {
                // Tous les champs sont remplis
                errorMessage.style.display = 'none';
                successMessage.innerHTML = 'Tous les champs sont correctement remplis.';
                successMessage.style.display = 'block';
                
                // Ici, vous pouvez ajouter le code pour soumettre le formulaire ou effectuer d'autres actions
            }
        });
    }

    // Appel de la fonction de validation pour le formulaire de connexion
    validateLoginForm('loginform', 'error-message-login', 'success-message-login');

    validateForm('registerform', 'error-message-register', 'success-message-register');
});
