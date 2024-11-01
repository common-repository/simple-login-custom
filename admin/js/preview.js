jQuery(document).ready(function($) {
	function updateRegisterFormPreview() {
    var formData = {
        'action': 'update_register_form_preview',
        'require_email_verification': $('input[name="customlogin_require_email_verification"]').is(':checked') ? 1 : 0,
        'require_phone': $('input[name="customlogin_require_phone"]').is(':checked') ? 1 : 0,
        'custom_login_nonce': customLoginSettings.nonce
    };

    $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: formData,
        success: function(response) {
            $('#register-form-preview').html(response);
        }
    });
}

$(document).on('change', 'input[name="customlogin_require_email_verification"], input[name="customlogin_require_phone"]', function() {
    updateRegisterFormPreview();
});

// Assurez-vous que cette fonction est appelée au chargement initial si nécessaire
updateRegisterFormPreview();

	
    // Fonction pour mettre à jour l'aperçu du formulaire de connexion
    function updateLoginFormPreview() {
        var formData = $('#custom-login-style-form').serialize(); // Récupérer les données du formulaire
		formData += '&custom_login_nonce=' + customLoginSettings.nonce;
        // Envoyer les données via AJAX et mettre à jour l'aperçu
        $.ajax({
            type: 'POST',
            url: ajaxurl, // URL du script PHP qui génère l'aperçu
            data: {
        action: 'update_login_form_preview', // Assurez-vous que l'action correspond
        form_data: formData
    },
            success: function(response) {
                $('#login-form-preview').html(response); // Mettre à jour l'aperçu avec la réponse du serveur
            }
        });
    }

    // Écouter les changements dans le formulaire et mettre à jour l'aperçu en conséquence
    $('#custom-login-style-form input, #custom-login-style-form select').on('input change', function() {
        updateLoginFormPreview();
    });

    // Appeler la fonction de mise à jour de l'aperçu au chargement de la page
    updateLoginFormPreview();

    // Fonction pour mettre à jour l'aperçu du lien personnalisé via AJAX
    function updateLoginLinkPreview() {
		var linkStyle = $('#custom-login-style-link').serialize();
		linkStyle += '&custom_login_nonce=' + customLoginSettings.nonce;
        $.ajax({
            url: ajaxurl, // Utilisez la variable ajaxurl pour accéder à l'URL du gestionnaire AJAX WordPress
            type: 'POST',
            data: {
                action: 'update_login_link_preview', // Action WordPress pour gérer la mise à jour de l'aperçu du lien
                link_style: linkStyle // Style du lien à envoyer au serveur
            },
            success: function(response) {
                // Mettre à jour l'élément contenant l'aperçu du lien avec la réponse du serveur
                $('#login-link-preview').html(response);
            }
        });
    }
	
	updateLoginLinkPreview();

    // Appeler la fonction pour mettre à jour l'aperçu du lien lorsqu'un changement est détecté dans le style du lien
    $('#custom-login-style-link input, #custom-login-style-link select').on('input change', function() {
        //var linkStyle = $(this).val();
        updateLoginLinkPreview();
    });
	
	// Afficher/Masquer les boutons de formulaire
	document.getElementById('toggle-form-buttons').addEventListener('change', function(e) {
    var isChecked = e.target.checked;
    
    // Afficher/Masquer les boutons de formulaire
    if (isChecked) {
        document.querySelectorAll('.form-navigation, .form-options').forEach(el => el.style.display = 'block');
    } else {
        document.querySelectorAll('.form-navigation, .form-options').forEach(el => el.style.display = 'none');
    }

    // Envoyer la valeur via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", ajaxurl, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
    xhr.send("action=update_custom_login_buttons&checked=" + (isChecked ? 1 : 0) + "&custom_login_nonce=" + customLoginSettings.nonce);
	});
    /*$('#toggle-form-buttons').on('change', function() {
        if ($(this).is(':checked')) {
            $('.form-navigation').show();
            $('.form-options').show();
        } else {
            $('.form-navigation').hide();
            $('.form-options').hide();
        }
    });*/

    // Vérification initiale
    if ($('#toggle-form-buttons').is(':checked')) {
        $('.form-navigation, .form-options').show();
    }

    // Basculer entre les formulaires
    $('.switch-form').on('click', function(e) {
        e.preventDefault();
        if ($(this).hasClass('login-btn')) {
            $('#register-form-preview').hide();
            $('#login-form-preview').show();
        } else {
            $('#login-form-preview').hide();
            $('#register-form-preview').show();
        }
    });
});
