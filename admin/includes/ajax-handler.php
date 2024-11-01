<?php
defined('ABSPATH') || exit;
// Ajouter une action pour le traitement AJAX
add_action('wp_ajax_update_login_form_preview', 'customlogin_update_login_form_preview_callback');

function customlogin_my_custom_wp_kses_allowed_html() {
    return array(
		'a' => array(
			'href' => array(),
			'style' => array(),
		),
        'div' => array(
            'class' => array(),
            'style' => array(),
        ),
        'form' => array(
            'name' => array(),
            'id' => array(),
            'action' => array(),
            'method' => array(),
        ),
        'p' => array(
            'class' => array(),
        ),
        'label' => array(
            'for' => array(),
        ),
        'input' => array(
            'type' => array(),
            'name' => array(),
            'id' => array(),
            'autocomplete' => array(),
            'class' => array(),
            'value' => array(),
            'size' => array(),
            'spellcheck' => array(),
        ),
        'checkbox' => array(
            'name' => array(),
            'type' => array(),
            'id' => array(),
            'value' => array(),
        ),
        'submit' => array(
            'type' => array(),
            'name' => array(),
            'id' => array(),
            'class' => array(),
            'value' => array(),
        ),
        'hidden' => array(
            'type' => array(),
            'name' => array(),
            'value' => array(),
        ),
    );
}

add_action('wp_ajax_update_register_form_preview', 'customlogin_update_register_form_preview');
add_action('wp_ajax_nopriv_update_register_form_preview', 'customlogin_update_register_form_preview');

function customlogin_update_register_form_preview() {
    check_ajax_referer('custom_login_form_action', 'custom_login_nonce');

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'simple-login-custom'));
    }

    $require_email_verification = isset($_POST['require_email_verification']) ? intval($_POST['require_email_verification']) : 0;
    $require_phone = isset($_POST['require_phone']) ? intval($_POST['require_phone']) : 0;

    $output = customlogin_generate_register_form_preview($require_email_verification, $require_phone);
    
    echo $output;
    wp_die();
}

function customlogin_generate_register_form_preview($require_email_verification, $require_phone) { // champs pas sur la meme ligne
    $form_max_width = get_option('customlogin_form_max_width', '100%');
    $form_background_color = get_option('customlogin_form_background_color', '#0FF000');
    $form_text_color = get_option('customlogin_form_text_color', '#00FF00');
    $form_border_color = get_option('customlogin_form_border_color', '#00FF00');
    $form_border_width = get_option('customlogin_form_border_width', '3px');
    $form_border_style = get_option('customlogin_form_border_style', 'solid');
    $form_border_padding = get_option('customlogin_form_border_padding', '1em');

    ob_start();
    ?>
    <div class="login-form-preview" style="max-width: <?php echo esc_attr($form_max_width); ?>;
        background-color: <?php echo esc_attr($form_background_color); ?>;
        color: <?php echo esc_attr($form_text_color); ?>;
        border: <?php echo esc_attr($form_border_width); ?> <?php echo esc_attr($form_border_style); ?> <?php echo esc_attr($form_border_color); ?>;
        padding: <?php echo esc_attr($form_border_padding); ?>;">
        <p><input type="text" name="user_name" placeholder="Nom d'utilisateur" /></p>
        <p><input type="email" name="user_email" placeholder="Email" /></p>
        <p><input type="password" name="user_pass" placeholder="Mot de passe" /></p>
        <p><input type="password" name="user_pass_confirm" placeholder="Confirmer le mot de passe" /></p>
        <p><input type="tel" name="user_phone" placeholder="Téléphone" /></p>
		<input type="submit" class="create-account-btn" value="Créer un compte" />
    </div>
    <?php
    return ob_get_clean(); // si tu enleve echo output die et ca ca marche aussi 
}

/*function customlogin_generate_register_form_preview($require_email_verification, $require_phone) { // champs sur la meme ligne
    $form_max_width = get_option('customlogin_form_max_width', '100%');
    $form_background_color = get_option('customlogin_form_background_color', '#0FF000');
    $form_text_color = get_option('customlogin_form_text_color', '#00FF00');
    $form_border_color = get_option('customlogin_form_border_color', '#00FF00');
    $form_border_width = get_option('customlogin_form_border_width', '3px');
    $form_border_style = get_option('customlogin_form_border_style', 'solid');
    $form_border_padding = get_option('customlogin_form_border_padding', '1em');

    ob_start();
    ?>
    <div class="login-form-preview" style="max-width: <?php echo esc_attr($form_max_width); ?>;
        background-color: <?php echo esc_attr($form_background_color); ?>;
        color: <?php echo esc_attr($form_text_color); ?>;
        border: <?php echo esc_attr($form_border_width); ?> <?php echo esc_attr($form_border_style); ?> <?php echo esc_attr($form_border_color); ?>;
        padding: <?php echo esc_attr($form_border_padding); ?>;">
        <input type="text" placeholder="Nom d'utilisateur" required />
        <input type="email" placeholder="Email" <?php echo $require_email_verification ? 'required' : ''; ?> />
        <input type="password" placeholder="Mot de passe" required />
        <input type="password" placeholder="Confirmer le mot de passe" required />
        <input type="tel" placeholder="Téléphone" <?php echo $require_phone ? 'required' : ''; ?> />
    </div>
    <?php
    return ob_get_clean();
}*/

function customlogin_update_login_form_preview_callback() {
	// parse_str($_POST['form_data'], $form_data_array); // Convertir la chaîne en tablea
	//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_login_nonce'])) {
    // Vérifier les autorisations d'accès
    if (current_user_can('manage_options')) {
        // Récupérer les données du formulaire
        if (wp_verify_nonce(wp_parse_args($_POST['form_data'])['custom_login_nonce'], 'custom_login_form_action')) {
        $form_data = isset($_POST['form_data']) ? sanitize_option("", $_POST['form_data']) : '';

        // Générer l'aperçu du formulaire de connexion en fonction des données du formulaire
        $preview_content = customlogin_generate_login_form_preview(wp_parse_args($form_data));

        // Retourner l'aperçu du formulaire de connexion
        echo wp_kses($preview_content, customlogin_my_custom_wp_kses_allowed_html());
    } else {
            // Nonce invalide
            wp_die(__('Nonce verification failed', 'simple-login-custom'));
        }
    } else {
    // Assurez-vous d'arrêter l'exécution une fois la réponse renvoyée
    wp_die(__('You do not have sufficient permissions to access this page.', 'simple-login-custom'));}
	wp_die();}
//}

function customlogin_generate_login_form_preview($form_data) {
    // Récupérer les valeurs spécifiques du formulaire
    $max_width = isset($form_data['customlogin_form_max_width']) ? $form_data['customlogin_form_max_width'] : '100%';
    $background_color = isset($form_data['customlogin_form_background_color']) ? $form_data['customlogin_form_background_color'] : '#FFFFFF';
    $text_color = isset($form_data['customlogin_form_text_color']) ? $form_data['customlogin_form_text_color'] : '#000000';
    $border_color = isset($form_data['customlogin_form_border_color']) ? $form_data['customlogin_form_border_color'] : '#000000';
    $border_style = isset($form_data['customlogin_form_border_style']) ? $form_data['customlogin_form_border_style'] : 'solid';
    $border_width = isset($form_data['customlogin_form_border_width']) ? $form_data['customlogin_form_border_width'] : '1px';
    $border_padding = isset($form_data['customlogin_form_border_padding']) ? $form_data['customlogin_form_border_padding'] : '10px';

    // Générer l'aperçu du formulaire de connexion en fonction des données du formulaire
    ob_start();
    ?>
    <div class="login-preview" style="max-width: <?php echo esc_attr($max_width); ?>;
									  background-color: <?php echo esc_attr($background_color); ?>;
                                       color: <?php echo esc_attr($text_color); ?>;
                                       border: <?php echo esc_attr($border_width); ?> <?php echo esc_attr($border_style); ?> <?php echo esc_attr($border_color); ?>;
                                       padding: <?php echo esc_attr($border_padding); ?>;">
        <!-- Insérez ici le code HTML du formulaire de connexion -->
        <?php
        $args = array(
            'redirect' => home_url(),
            'id_username' => 'user',
            'id_password' => 'pass',
        );

        wp_login_form($args);
        ?>
    </div>
    <?php
    return ob_get_clean();
}

// Ajouter une action pour le traitement AJAX de la mise à jour de l'aperçu du lien personnalisé
add_action('wp_ajax_update_login_link_preview', 'customlogin_update_login_link_preview_callback');

function customlogin_update_login_link_preview_callback() {
	// parse_str($_POST['link_style'], $form_data_array); // Convertir la chaîne en tablea
	//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_login_nonce'])) {
    // Vérifier les autorisations d'accès
    if (current_user_can('manage_options')) {
        // Récupérer le style du lien personnalisé envoyé via AJAX
        if (wp_verify_nonce(wp_parse_args($_POST['link_style'])['custom_login_nonce'], 'custom_login_form_action')) {
        $link_style = isset($_POST['link_style']) ? sanitize_option("", $_POST['link_style']) : '';

        // Générer l'aperçu du lien personnalisé avec le style spécifié
        $login_link_preview = customlogin_generate_login_link_preview(wp_parse_args($link_style));

        // Retourner l'aperçu du lien personnalisé
        echo wp_kses($login_link_preview, customlogin_my_custom_wp_kses_allowed_html());
    } else {
            // Nonce invalide
            wp_die(esc_html__('Nonce verification failed', 'text-domain'));
        }
    } else {
    // Assurez-vous d'arrêter l'exécution une fois la réponse renvoyée
    wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'text-domain'));}

    // Assurez-vous d'arrêter l'exécution une fois la réponse renvoyée
    wp_die();
	//}
}

function customlogin_generate_login_link_preview($link_style) {
    // Générer l'aperçu du lien personnalisé en fonction du style spécifié
    // Vous pouvez personnaliser cette fonction pour produire l'aperçu du lien personnalisé en utilisant le style fourni
/*error_log($link_style);*/
    // Exemple de code pour générer un aperçu basique du lien
    //$login_link_preview = '<a href="#" style="' . esc_attr($link_style) . '">Lien personnalisé</a>';
	$link_color = isset($link_style['customlogin_link_color']) ? $link_style['customlogin_link_color'] : '#000000';
	$link_underline_style = isset($link_style['customlogin_link_underline_style']) ? $link_style['customlogin_link_underline_style'] : 'none';
	// Concaténer les styles de couleur et de soulignement dans la variable $link_style
$link_style_fuse = '" style="color: ' . esc_attr($link_color) . '; text-decoration: ' . esc_attr($link_underline_style) . ';">';
    $text_normal = isset($link_style['customlogin_link_text_normal']) ? $link_style['customlogin_link_text_normal'] : 'Veuillez vous';
    // Récupérer le texte du lien
    $link_text = isset($link_style['customlogin_link_text']) ? $link_style['customlogin_link_text'] : 'identifier';
    // Récupérer l'ID du paragraphe de description
    $login_desc_id = isset($link_style['customlogin_desc_id']) ? $link_style['customlogin_desc_id'] : 'login-desc';

    // Générer le lien
    $login_link = home_url() . '/#' . $login_desc_id;

    $login_link_preview = '<p>' . esc_html($text_normal) . ' <a href="' . esc_url($login_link) . $link_style_fuse . esc_html($link_text) . '</a></p>';/*error_log($login_link_preview);*/
    return $login_link_preview;
}

add_action('wp_ajax_update_custom_login_buttons', 'update_custom_login_buttons_callback');

function update_custom_login_buttons_callback() {
    if (!isset($_POST['custom_login_nonce']) || !wp_verify_nonce(
		$_POST['custom_login_nonce'], 'custom_login_form_action')) {
        wp_send_json_error('Nonce verification failed');
        return;
    }

    $checked = isset($_POST['checked']) ? (int)$_POST['checked'] : 0;
    update_option('customlogin_show_buttons', $checked);
    wp_send_json_success('Option updated');
}
