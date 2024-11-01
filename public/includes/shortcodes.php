<?php
defined('ABSPATH') || exit;
// register-form vs registerform a etudier c un truc de fou furieux
function customlogin_form_shortcode() {
    $domain = get_option('customlogin_domain', 'example.com');
    $login_desc_id = get_option('customlogin_desc_id', 'login-desc');
    $form_style = 'max-width:' . get_option('customlogin_form_max_width', '100%');
    $form_style .= '; border-color:' . get_option('customlogin_form_border_color', '#00FF00');
    $form_style .= '; border-style:' . get_option('customlogin_form_border_style', 'solid');
    $form_style .= '; border-width:' . get_option('customlogin_form_border_width', '3px');
    $form_style .= '; padding:' . get_option('customlogin_form_border_padding', '1em') . ';';
    $form_background_color = get_option('customlogin_form_background_color', '#FFFFFF');
    $form_text_color = get_option('customlogin_form_text_color', '#000000');

    $form_style .= ' background-color:' . $form_background_color . '; color:' . $form_text_color . ';';

    $is_register_active = get_option('customlogin_show_buttons', false);

    ob_start(); ?>
    <div class="login-branding">
        <a href="#" class="login-logo"><strong><?php echo esc_html($domain); ?></strong></a>
        <p id="<?php echo esc_attr($login_desc_id); ?>" class="login-desc">
            <!-- Description ici -->
        </p>
    </div>
    
    <?php if($is_register_active): ?>
    <div class="form-navigation" style="display:block;">
        <button class="switch-form login-btn" id="switch-login-btn" ><?php echo esc_html__('Se connecter', 'simple-login-custom') ?></button>
        <button class="switch-form register-btn" id="switch-register-btn" ><?php echo esc_html__('Créer un compte', 'simple-login-custom') ?></button>
    </div>
    <?php endif; ?>

    <div class="login-form-container" style="<?php echo esc_attr($form_style); ?>">
        <div class="login-form" id="login-form">
			<div id="success-message-login" class="error-message" style="display: none;"></div>
			<div id="error-message-login" class="error-message" style="display: none;"></div>
            <?php
            $args = array(
                'redirect' => home_url(),
                'id_username' => 'user',
                'id_password' => 'pass',
            );

            if (!is_user_logged_in()) {
                wp_login_form($args);
            } else {
                $logout_url = wp_logout_url(home_url());
                echo '<a class="ab-item" href="' . esc_url($logout_url) . '">' . esc_html__('Se déconnecter', 'simple-login-custom') . '</a>';
            }
            ?>
        </div>

        <?php if($is_register_active): ?>
        <div class="register-form" id="register-form" style="display:none;">
            <form name="registerform" id="registerform" action="<?php echo esc_url(site_url('wp-login.php?action=register', 'login_post')); ?>" method="post" novalidate="novalidate">
				<!--<?php wp_nonce_field('custom_register_nonce', 'nonce'); ?>-->
                <p><input type="text" name="user_login" id="user_login" placeholder="Nom d'utilisateur" required /></p>
                <p><input type="email" name="user_email" id="user_email" placeholder="Email" required /></p>
                <p><input type="password" name="user_pass" id="user_pass" placeholder="Mot de passe" required /></p>
                <p><input type="password" name="user_pass_confirm" id="user_pass_confirm" placeholder="Confirmer le mot de passe" required /></p>
                <p><input type="tel" name="user_phone" id="user_phone" placeholder="Téléphone" /></p>
				<div id="success-message-register" style="display: none;"></div>
				 <div id="error-message-register" class="error-message" style="display: none;"></div>
                <input type="submit" class="create-account-btn" id="register-btn" value="Créer un compte" name="wp-submit" />
                <?php
                // Ajout des champs nécessaires pour WordPress
                ?>
                <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url()); ?>" />
                <?php wp_nonce_field('registerform'); ?>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <?php
    // Messages d'erreur comme dans votre code initial
    $login_statuses = array(
        'failed' => esc_html__('ERREUR: Nom d\'utilisateur et/ou Mot de passe invalides.', 'simple-login-custom'),
        'empty' => esc_html__('ERREUR: Nom d\'utilisateur et/ou Mot de passe vide.', 'simple-login-custom'),
        'false' => esc_html__('ERREUR: Vous êtes déconnecté.', 'simple-login-custom')
    );

    $login = isset($_GET['login']) ? sanitize_text_field($_GET['login']) : '';
    foreach ($login_statuses as $key => $message) {
        if ($login === $key) {
            echo '<p class="login-msg"><strong>ERROR:</strong> ' . esc_html($message) . '</p>';
        }
    }

    wp_enqueue_script('login-register-form-toggle', plugin_dir_url(__FILE__) . '../js/login-register.js', array('jquery'), '1.0.0', true);
    return ob_get_clean();
}

// Il faut ajouter du JavaScript pour gérer le changement entre les formulairesa
// SCRIPT NORMALLY

/*document.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.querySelector('.login-btn');
    const registerBtn = document.querySelector('.register-btn');
    const loginForm = document.querySelector('.login-form');
    const registerForm = document.querySelector('.register-form');

    if(loginBtn && registerBtn && loginForm && registerForm) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        });

        registerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });
    }
});*/


add_shortcode('customlogin_form', 'customlogin_form_shortcode');

/*
// Function to display custom login form
function customlogin_form_shortcode() {
    // Récupérer les options de configuration du plugin
    $domain = get_option('customlogin_domain', 'example.com');
    $login_desc_id = get_option('customlogin_desc_id', 'login-desc');
    $form_style = 'max-width:' . get_option('customlogin_form_max_width', '100%');
    $form_style .= '; border-color:' . get_option('customlogin_form_border_color', '#00FF00');
    $form_style .= '; border-style:' . get_option('customlogin_form_border_style', 'solid');
    $form_style .= '; border-width:' . get_option('customlogin_form_border_width', '3px');
    $form_style .= '; padding:' . get_option('customlogin_form_border_padding', '1em') . ';';
    $form_background_color = get_option('customlogin_form_background_color', '#FFFFFF');
    $form_text_color = get_option('customlogin_form_text_color', '#000000');
    
    // Concaténer les styles de couleur à la variable $form_style
    $form_style .= ' background-color:' . $form_background_color . '; color:' . $form_text_color;
    
    ob_start(); ?>
    <div class="login-branding">
        <a href="#" class="login-logo"><strong><?php echo esc_html($domain); ?></strong></a>
        <p id="<?php echo esc_attr($login_desc_id); ?>" class="login-desc">
        <!-- Votre description ici -->
        </p>
    </div>

    <div class="login-form" style="<?php echo esc_attr($form_style); ?>">
        <?php
        $args = array(
            'redirect' => home_url(),
            'id_username' => 'user',
            'id_password' => 'pass',
            //'label_username' => __('Username or Email Address', 'simple-login-custom'),
            //'label_password' => __('Password', 'simple-login-custom'),
            //'label_log_in'   => __('Log In', 'simple-login-custom'),
        );

        if (!is_user_logged_in()) {
            wp_login_form($args);
        } else {
            $logout_url = wp_logout_url(home_url());
            echo '<a class="ab-item" href="' . esc_url($logout_url) . '">' . __('Se déconnecter', 'simple-login-custom') . '</a>';
        }
        ?>
    </div>

    <?php
    $login_statuses = array(
        'failed' => __('ERROR: Invalid username and/or password.', 'simple-login-custom'),
        'empty' => __('ERROR: Username and/or Password is empty.', 'simple-login-custom'),
        'false' => __('ERROR: You are logged out.', 'simple-login-custom')
    );

    $login = isset($_GET['login']) ? sanitize_text_field($_GET['login']) : '';
    foreach ($login_statuses as $key => $message) {
        if ($login === $key) {
            echo '<p class="login-msg"><strong>ERROR:</strong> ' . esc_html($message) . '</p>';
        }
    }

    return ob_get_clean();
}
add_shortcode('customlogin_form', 'customlogin_form_shortcode');
*/
// Shortcode to display the link to custom form with custom text
function customlogin_link_shortcode() {
    if (is_user_logged_in())
        return '';
    
    $link_color = get_option('customlogin_link_color', '#000000');
    $link_underline_style = get_option('customlogin_link_underline_style', 'none');
    $link_style = '" style="color: ' . esc_attr($link_color) . '; text-decoration: ' . esc_attr($link_underline_style) . ';">';
    $text_normal = get_option('customlogin_link_text_normal', esc_html__('Please', 'simple-login-custom'));
    $link_text = get_option('customlogin_link_text', esc_html__('log in', 'simple-login-custom'));
    $login_desc_id = get_option('customlogin_desc_id', 'login-desc');

    $login_link = home_url() . '/#' . $login_desc_id;

    return '<p>' . esc_html($text_normal) . ' <a href="' . esc_url($login_link) . $link_style . esc_html($link_text) . '</a></p>';
}
add_shortcode('customlogin_link', 'customlogin_link_shortcode');
