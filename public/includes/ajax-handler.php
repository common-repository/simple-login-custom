<?php
defined('ABSPATH') || exit;

// Dans functions.php ou un plugin personnalisé

add_action('wp_ajax_nopriv_custom_register', 'custom_register_user');
add_action('wp_ajax_custom_register', 'custom_register_user');

function custom_register_user() {
	// Log pour débogage
    error_log('Requête AJAX reçue pour l\'inscription');

    // Vérifier le nonce pour la sécurité
    if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'custom_register_nonce') ) {
        error_log('Nonce invalide: ' . (isset($_POST['nonce']) ? $_POST['nonce'] : 'Non défini'));
        wp_send_json_error(array('message' => 'Nonce invalide. Veuillez rafraîchir la page et réessayer.'));
    }
	
    // Vérifier le nonce pour la sécurité
    check_ajax_referer('custom_register_nonce', 'nonce');

    // Récupérer et nettoyer les données du formulaire
    $username = sanitize_user($_POST['user_login']);
    $email = sanitize_email($_POST['user_email']);
    $password = $_POST['user_pass'];
    $password_confirm = $_POST['user_pass_confirm'];

    // Initialiser un tableau d'erreurs
    $errors = array();

    // Valider les champs requis
    if (empty($username)) {
        $errors[] = 'Le nom d\'utilisateur est requis.';
    }

    if (empty($email)) {
        $errors[] = 'L\'adresse e-mail est requise.';
    } elseif (!is_email($email)) {
        $errors[] = 'L\'adresse e-mail n\'est pas valide.';
    }

    if (empty($password)) {
        $errors[] = 'Le mot de passe est requis.';
    }

    if ($password !== $password_confirm) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }

    // Vérifier si le nom d'utilisateur ou l'e-mail existe déjà
    if (username_exists($username)) {
        $errors[] = 'Cet identifiant est déjà utilisé. Veuillez en choisir un autre.';
    }

    if (email_exists($email)) {
        $errors[] = 'Cet e-mail est déjà utilisé. Veuillez en choisir un autre.';
    }

    // Si des erreurs existent, les renvoyer
    if (!empty($errors)) {
        wp_send_json_error(array('message' => implode('<br>', $errors)));
    }

    // Créer le nouvel utilisateur
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
    }

    // Optionnel : Connecter automatiquement l'utilisateur après l'inscription
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    // Renvoi d'une réponse réussie
    wp_send_json_success(array('message' => 'Inscription réussie ! Bienvenue.'));
}
